<div x-data="{
        gridView: '',
        chooseView(view) {
            if (view === 'list' && this.gridView !== 'list') {
                this.changeActive('list', this.$refs.listButton, this.$refs.cardButton);
                this.$refs.productRow.classList.remove('card-style');
            } else if (view === 'card' && this.gridView !== 'card') {
                this.changeActive('card', this.$refs.cardButton, this.$refs.listButton);
                this.$refs.productRow.classList.add('card-style');
            }
        },
        changeActive(view, active, inactive) {
            this.gridView = view;
            this.$dispatch('change-product-grid-view', { view: view })
            this.makeActive(active);
            this.makeInactive(inactive);
        },
        makeActive(el) {
            this.clearClass(el);
            el.classList.add('text-primary');
        },
        makeInactive(el) {
            this.clearClass(el);
            el.classList.add('text-primary/25');
        },
        clearClass(el) {
            el.classList.remove('text-primary', 'text-primary/25')
        }
    }" x-init="gridView = '{{ $gridView }}'">
    @include("cp::web.catalog.includes.product.controls")

    @if (! $products->count())
        <div>По вашему запросу ничего не найдено</div>
    @else
        <div class="row product-row {{ $gridView === 'card' ? 'card-style' : '' }}" x-ref="productRow">
            @foreach($products as $item)
                @php($product = \GIS\CategoryProduct\Facades\ProductActions::getTeaserData($item->id))
                <div class="col product-col mb-indent">
                    <x-cp::product.teaser :product="$product" />
                </div>
            @endforeach
        </div>
        <div class="flex justify-between">
            <div>Всего: {{ $products->total() }}</div>
            {{ $products->links("tt::pagination.live") }}
        </div>
    @endif
</div>

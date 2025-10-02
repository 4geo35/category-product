const plugin = require("tailwindcss/plugin")

module.exports = plugin.withOptions(function (options = {}) {
    return ({ addComponents, theme }) => {
        const breakpoints = theme("breakpoint")
        const bp2xl = "@media (min-width: " + breakpoints['2xl'] + ")";
        const bpxl = "@media (min-width: " + breakpoints['xl'] + ")";
        const bplg = "@media (min-width: " + breakpoints['lg'] + ")";
        const bpmd = "@media (min-width: " + breakpoints['md'] + ")";
        const bpsm = "@media (min-width: " + breakpoints['sm'] + ")";
        const bpxs = "@media (min-width: " + breakpoints['xs'] + ")";

        const components = {
            ".product-row": {
                "& .product-col": {
                    width: "100%",
                },

                "&.card-style .product-col": {
                    width: "100%",
                    [bpsm]: {
                        width: "calc(1/2 * 100%)"
                    },
                    [bpxl]: {
                        width: "calc(1/3 * 100%)"
                    }
                },

                "& .product-teaser": {
                    flexDirection: "row"
                },

                "&.card-style .product-teaser": {
                    flexDirection: "column"
                }
            },
        }

        addComponents(components)
    }
})

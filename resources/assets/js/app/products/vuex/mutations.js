export const setProducts = (state, data) => {
    state.products = data.data
    state.fields = data.fields
    state.meta = data.meta
    state.links = data.links
};

export const setActiveProduct = (state, data) => {
    state.activeProduct = data.data
};

export const setProductInventory = (state, data) => {
    state.productInventory.data = data.data
    state.productInventory.meta = data.meta
    state.productInventory.links = data.links
};

export const removeProduct = (state, productId) => {
    let products = state.products;

    state.products = _.remove(products, function(p) {
        return p.id !== productId;
    })
};
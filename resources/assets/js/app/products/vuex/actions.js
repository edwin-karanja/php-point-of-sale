export const getProducts = ({ commit, state }, page=state.meta.current_page) => {
    let str = state.searchText;
    let sortColumn = state.sort.column;
    let sortOrder = state.sort.order;
    let deleted = state.deleted
    axios.get('admin/items', {
        params: {
            page: page,
            search: str,
            sort_column: sortColumn,
            order: sortOrder,
            deleted: deleted
        }
    }).then((response) => {
        commit('setProducts', response.data);
    });
};

export const searchProducts = ({ dispatch, state }, str) => {
    state.searchText = str;
    dispatch('getProducts');
};

export const sortProducts = ({ dispatch, state }, sort) => {
    state.sort = sort

    dispatch('getProducts');
};


export const getProductData = ({ commit, dispatch }, id) => {
    axios.get('admin/items/'+ id).then((response) => {
        commit('setActiveProduct', response.data)
        dispatch('fetchProductInventory', 1)
    })
};

export const fetchProductInventory = ({ commit, state }, page) => {
    let product_id = state.activeProduct.id;
    axios.get('admin/inventory/'+ product_id, {
        params: {
            page: page
        }
    }).then((res) => {
        commit('setProductInventory', res.data);
    })
};

export const deleteProduct = ({ commit }, product_id) => {
    axios.delete('admin/items/' + product_id).then((response) => {
        commit('removeProduct', product_id);
    })
};

export const showDeleted = ({ dispatch, state }, del) => {
    state.deleted = del
    dispatch('getProducts');
};

export const restoreProduct = ({ commit }, product) => {
    axios.post('admin/items/restore/' + product.id).then((response) => {
        commit('removeProduct', product.id);
    })
}
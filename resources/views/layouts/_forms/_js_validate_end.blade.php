// Init Validation on Select2 change
jQuery('.js-select2').on('change', e => {
jQuery(e.currentTarget).valid();
});
}

/*
* Init functionality
*
*/
static init() {
this.initValidation();
}
}

// Initialize when page loads
jQuery(() => { pageFormsValidation.init(); });
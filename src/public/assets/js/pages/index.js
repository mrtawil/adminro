class IndexClass {
    constructor() {
        this.collapse = true;
    }

    initFields() {
        $("#all_collapse").on("click", () => {
            this.toggleAllCollapse();
        });
    }

    toggleAllCollapse() {
        if (this.collapseShown) {
            $(".collapse").collapse("hide");
        } else {
            $(".collapse").collapse("show");
        }

        this.collapseShown = !this.collapseShown;
    }

    mounted() {
        this.initFields();
    }
}

window.addEventListener('DOMContentLoaded', () => {
    var indexClass = new IndexClass();
    indexClass.mounted();
});

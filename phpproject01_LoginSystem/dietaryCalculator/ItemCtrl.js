export class ItemCtrl {
    constructor() {
        this.data = [];
        this.requestData = [];
        this.currentItem = null;
    }
    addItem(fname, famount, funits) {
        let id;

        if (this.data.length > 0) {
            let maxId = 0;
            this.data.forEach((item) => {
                if (item.id <= maxId) {
                    maxId = item.id + 1;
                }
            });
            id = maxId;
        } else {
            id = 0;
        }

        let foodItem = { id, fname, famount, funits };

        this.data.push(foodItem);

        return id;
    }
    logAllItems() {
        console.log(this.data);
    }
    removeItem(id) {
        const ids = this.data.map((item) => {
            return item.id;
        });

        const index = ids.indexOf(id);

        this.data.splice(index, 1);
    }
    getCurrentItem() {
        return this.data.currentItem;
    }
    setCurrentItem(item) {
        this.currentItem = item;
    }
    getItemById(id) {
        let idItem = null;
        this.data.map((item) => {
            if (item.id === id) {
                idItem = item;
            }
        });
        return idItem;
    }
    updateListItem(fname, famount, funits) {
        (this.currentItem.foodName = fname),
            (this.currentItem.foodAmount = famount),
            (this.currentItem.foodUnits = funits);

        const id = this.currentItem.id;
        this.data.forEach((item, index) => {
            if (item.id === id) {
                this.data.splice(1, index, this.currentItem);
            }
        });
    }
    clearAll() {
        this.data = [];
        this.currentItem = null;
    }
}
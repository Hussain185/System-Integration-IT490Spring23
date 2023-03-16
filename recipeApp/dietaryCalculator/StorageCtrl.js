export class storageCtrl {
    storeItem(foodItem) {
        const foodItems = this.getItemsFromStorage();
        foodItems.push(foodItem);

        localStorage.setItem("foodItems", JSON.stringify(foodItems));
    }
    getItemsFromStorage() {
        let foodItems;
        if (localStorage.getItem("foodItems") === null) {
            foodItems = [];
        } else {
            foodItems = JSON.parse(localStorage.getItem("foodItems"));
        }
        return foodItems;
    }
    removeItemFromStorage(id) {
        const foodItems = this.getItemsFromStorage();

        foodItems.forEach((item, index) => {
            if (item.id === id) {
                foodItems.splice(index, 1);
            }
        });
        localStorage.setItem("foodItems", JSON.stringify(foodItems));
    }
    clearFromLocalStorage() {
        localStorage.clear();
    }
}
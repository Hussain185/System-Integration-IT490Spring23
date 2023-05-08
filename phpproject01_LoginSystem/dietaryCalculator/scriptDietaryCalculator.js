import { ItemCtrl } from "./ItemCtrl.js";
import { storageCtrl } from "./StorageCtrl.js";
import { UICtrl } from "./UiCtrl.js";
import { httpReq } from "./http.js";

export class App {
    constructor() {
        (this.UICtrl = new UICtrl()),
            (this.ItemCtrl = new ItemCtrl()),
            (this.storageCtrl = new storageCtrl()),
            (this.httpReq = new httpReq());

        this.listEditState = true;
    }

    listElementEditColor(a) {
        if (a.target.className === "fa fa-edit align-items-md-end") {
            this.UICtrl.showEditState();
            a.target.parentNode.parentNode.style = "background-color:#e8dddc";
        }
    }
    listElementUpdateColor(a) {
        const id = this.ItemCtrl.currentItem.id;
        const itemNames = (document.getElementById(
            `item-${id}`,
        ).firstChild.style = "background-color:#c3c3f7");
    }

    listElementInitColorAll() {
        const listItems = document.querySelector(`.list-group`).childNodes;
        listItems.forEach((item) => {
            item.childNodes[1].style = "";
        });
    }

    listEditState() {
        if (this.listEditState) {
        }
    }

    loadEventListeners() {
        const itemNames = this.UICtrl.getUISelectors();

        document
            //add items
            .getElementById(itemNames.addbtn)
            .addEventListener("click", () => {
                this.ItemCtrl.data = this.storageCtrl.getItemsFromStorage();
                const item = this.UICtrl.getFoodValues();

                try {
                    const id = this.ItemCtrl.addItem(
                        item.foodName,
                        item.foodAmount,
                        item.foodUnits,
                    );

                    this.UICtrl.createListGroupItem(
                        id,
                        item.foodName,
                        item.foodAmount,
                        item.foodUnits,
                    );
                    item.id = id;
                    this.storageCtrl.storeItem(item);

                    this.UICtrl.showMessage("added");
                    this.UICtrl.showList(true);

                    this.httpReq.get(id, item.foodName, item.foodAmount);
                } catch (e) {
                    console.log(e);
                    return;
                }
            });
        document
            //dropdown units
            .querySelector(itemNames.ddmenu)
            .addEventListener("click", (a) => {
                document.getElementById(
                    itemNames.dshow,
                ).childNodes[1].textContent = a.target.textContent;
            });

        document
            .querySelector(itemNames.lgroup)
            .addEventListener("click", (a) => {
                this.listElementInitColorAll();
                this.listElementEditColor(a);

                const id = parseInt(
                    a.target.parentNode.parentNode.parentNode.id.split("-")[1],
                );

                const currItem = this.ItemCtrl.getItemById(id);
                this.ItemCtrl.setCurrentItem(currItem);
            });
        document
            .getElementById(itemNames.delbtn)
            .addEventListener("click", () => {
                const id = this.ItemCtrl.currentItem.id;
                this.UICtrl.deleteListElement(id);
                this.ItemCtrl.removeItem(id);
                this.UICtrl.clearEditState();
                this.httpReq.removeDataItem(id);
                this.storageCtrl.removeItemFromStorage(id);

                this.UICtrl.showMessage("removed");

                if (this.ItemCtrl.data.length === 0) {
                    this.UICtrl.showList(false);
                }

                this.UICtrl.showInitState();
            });
        document
            .getElementById(itemNames.updbtn)
            .addEventListener("click", () => {
                this.UICtrl.setFoodValuesForms(
                    this.ItemCtrl.currentItem.foodName,
                    this.ItemCtrl.currentItem.foodAmount,
                    this.ItemCtrl.currentItem.foodUnits,
                );

                this.UICtrl.switchButtonsAddChange();
                this.listElementUpdateColor();

                const id = this.ItemCtrl.currentItem.id;
            });
        document
            .getElementById(itemNames.cancelbtn)
            .addEventListener("click", () => {
                this.listElementInitColorAll();
                this.UICtrl.showInitState();
            });
        document
            .getElementById(itemNames.changebtn)
            .addEventListener("click", () => {
                const id = this.ItemCtrl.currentItem.id;
                this.UICtrl.submitChange(id);

                const gotItems = this.UICtrl.getFoodValues();
                gotItems.id = id;

                this.ItemCtrl.updateListItem(
                    gotItems.foodName,
                    gotItems.foodAmount,
                    gotItems.foodUnits,
                );

                this.httpReq.removeDataItem(id);

                this.httpReq.get(id, gotItems.foodName, gotItems.foodAmount);

                this.storageCtrl.removeItemFromStorage(id);
                this.storageCtrl.storeItem(gotItems);

                this.UICtrl.showMessage("updated");

                this.UICtrl.showInitState();
            });
        document.addEventListener("DOMContentLoaded", () => {
            const foodItems = this.storageCtrl.getItemsFromStorage();
            this.ItemCtrl.data = foodItems;
            if (foodItems.length > 0) {
                this.UICtrl.showList(true);
            }
            this.UICtrl.createListFromArray(foodItems);

            this.httpReq.UpdateSumData();
        });

        document
            .getElementById(itemNames.clearbtn)
            .addEventListener("click", () => {
                this.UICtrl.clearListItems();
                this.ItemCtrl.clearAll();
                this.storageCtrl.clearFromLocalStorage();
                this.httpReq.clearData();
            });
    }
}

const app = new App();
app.loadEventListeners();
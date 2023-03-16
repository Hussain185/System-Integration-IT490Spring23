export class UICtrl {
    getUISelectors() {
        return {
            fname: "food-name",
            famount: "food-amount",
            funits: "dropdown-units",
            calgained: "calories-gained",
            protgained: "prot-gained",
            carbgained: "carbs-gained",
            fatgained: "fat-gained",
            fibgained: "fiber-gained",
            addbtn: "addbtn",
            dshow: "drop-show",
            ddmenu: ".dropdown-menu",
            lgroup: ".list-group",
            lgitem: ".list-group-item",
            updbtn: "upd-btn",
            delbtn: "del-btn",
            cancelbtn: "cancel-btn",
            changebtn: "change-btn",
            container: ".container.mt-4",
            card: ".col-md-6.mx-auto",
            listcalc: "nutr-calc",
            clearbtn: "clear-btn",
        };
    }
    getFoodValues() {
        const itemNames = this.getUISelectors();

        const foodName = document.getElementById(itemNames.fname).value;
        const foodAmount = document.getElementById(itemNames.famount).value;
        const foodUnits = document
            .getElementById(itemNames.dshow)
            .childNodes[1].textContent.split(/\s+/)
            .reverse()[0];

        if (foodName === "" || foodAmount === "") {
            this.showMessage("empty");
        } else {
            if (parseFloat(foodAmount) > 0) {
                return {
                    foodName: foodName,
                    foodAmount: foodAmount,
                    foodUnits: foodUnits,
                };
            } else {
                this.showMessage("greaterThanZero");
            }
        }
    }
    setFoodValuesForms(foodName, foodAmount, foodUnits) {
        const itemNames = this.getUISelectors();

        document.getElementById(itemNames.fname).value = foodName;
        document.getElementById(itemNames.famount).value = foodAmount;
        document.getElementById(
            itemNames.dshow,
        ).childNodes[1].textContent = foodUnits;
    }

    logFoodValues() {
        const itemNames = this.getUISelectors();
        const foodName = document.getElementById(itemNames.fname).value;
        const foodAmount = document.getElementById(itemNames.famount).value;
        const foodUnits = document
            .getElementById(itemNames.dshow)
            .childNodes[1].textContent.split(/\s+/)
            .reverse()[0];

        console.log(`${foodAmount} ${foodUnits} of ${foodName} `);
    }
    createListGroupItem(id, foodName, foodAmount, foodUnits) {
        const itemNames = this.getUISelectors();

        const listGroup = document.querySelector(itemNames.lgroup);

        listGroup.innerHTML += `<div id="item-${id}">
        <button 
            class="list-group-item list-group-item-action d-flex justify-content-between style=''">
            <span>
                <strong>${foodAmount}</strong> ${foodUnits} of <strong>${foodName}</strong>
            </span>
            <span>
                <i class="fa fa-edit align-items-md-end"></i>
            </span>
        </button>
    </div>`;
    }

    submitChange(id) {
        const LGItem = document.querySelector(`#item-${id}`);

        const gotItems = this.getFoodValues();

        LGItem.innerHTML = `<button type="button" class="list-group-item list-group-item-action d-flex justify-content-between"><span><strong>${gotItems.foodAmount}</strong> ${gotItems.foodUnits} of <strong>${gotItems.foodName}</strong></em></span><span><i class="fa fa-edit align-items-md-end" ></i></span></button>`;
    }
    deleteListElement(id) {
        const itemId = `#item-${id}`;
        const item = document.querySelector(itemId);
        item.remove();
    }
    showInitState() {
        const itemNames = this.getUISelectors();
        document.getElementById(itemNames.addbtn).style.display = "inline";
        document.getElementById(itemNames.changebtn).style.display = "none";

        document.getElementById(itemNames.addbtn).disabled = false;
        document.getElementById(itemNames.addbtn).className =
            "btn btn-primary btn-block";
        document.getElementById(itemNames.fname).disabled = false;
        document.getElementById(itemNames.famount).disabled = false;
        document.getElementById(itemNames.funits).disabled = false;

        document.getElementById(itemNames.fname).value = "";
        document.getElementById(itemNames.famount).value = "";
        document.getElementById(itemNames.funits).value = "grams";

        this.clearEditState();
    }
    showEditState() {
        const itemNames = this.getUISelectors();
        document.getElementById(itemNames.updbtn).style.display = "inline";
        document.getElementById(itemNames.delbtn).style.display = "inline";
        document.getElementById(itemNames.cancelbtn).style.display = "inline";

        document.getElementById(itemNames.addbtn).disabled = true;
        document.getElementById(itemNames.fname).disabled = true;
        document.getElementById(itemNames.famount).disabled = true;
        document.getElementById(itemNames.funits).disabled = true;
    }

    clearEditState() {
        const itemNames = this.getUISelectors();
        document.getElementById(itemNames.updbtn).style.display = "none";
        document.getElementById(itemNames.delbtn).style.display = "none";
        document.getElementById(itemNames.cancelbtn).style.display = "none";
    }
    switchButtonsAddChange() {
        const itemNames = this.getUISelectors();

        document.getElementById(itemNames.addbtn).style.display = "none";
        document.getElementById(itemNames.changebtn).style.display =
            "inline-block";

        document.getElementById(itemNames.fname).disabled = false;
        document.getElementById(itemNames.famount).disabled = false;
        document.getElementById(itemNames.funits).disabled = false;
    }
    createMessage(message, id) {
        const itemNames = this.getUISelectors();
        const container = document.querySelector(itemNames.container);
        const card = document.querySelector(itemNames.card);

        if (document.getElementById("message") !== null) {
            document.getElementById("message").remove();

            const element = document.createElement("div");
            element.id = "message";

            element.innerHTML = `<div class="container mt-4" >
            <div class="card mb-2" id=${id}>
              <div class="card-body">
                <p class="card-text">${message}</p>
              </div>
            </div>`;

            container.insertBefore(element, card);

            setTimeout(() => {
                element.remove();
            }, 2000);
        } else {
            const element = document.createElement("div");
            element.id = "message";

            element.innerHTML = `<div class="container mt-4" >
        <div class="card mb-2" id=${id}>
          <div class="card-body">
            <p class="card-text">${message}</p>
          </div>
        </div>`;

            container.insertBefore(element, card);

            setTimeout(() => {
                element.remove();
            }, 2000);
        }
    }
    showList(val) {
        const itemNames = this.getUISelectors();

        if (val === true) {
            document.getElementById(itemNames.listcalc).style.display = "block";
        } else if (val === false) {
            document.getElementById(itemNames.listcalc).style.display = "none";
        }
    }
    showMessage(key) {
        switch (key) {
            case "added":
                this.createMessage("Food item added!", "added");
                break;
            case "updated":
                this.createMessage("Food item updated", "updated");
                break;

            case "removed":
                this.createMessage("Food item removed", "removed");
                break;

            case "empty":
                this.createMessage("Please fill in all values", "empty");

            case "greaterThanZero":
                this.createMessage(
                    "Please enter values greater than zero",
                    "greater-than-zero",
                );

            default:
                break;
        }
    }
    clearListItems() {
        const itemNames = this.getUISelectors();
        const list = document.querySelector(itemNames.lgroup);

        if (confirm("Are You Sure?")) {
            while (list.firstElementChild) {
                list.firstElementChild.remove();
            }
        }
        this.showList(false);
    }
    createListFromArray(objArray) {
        const itemNames = this.getUISelectors();
        const list = document.querySelector(itemNames.lgroup);
        let html = "";
        objArray.forEach((element) => {
            html += `<div id="item-${element.id}">
            <button 
                class="list-group-item list-group-item-action d-flex justify-content-between style=''">
                <span>
                    <strong>${element.foodAmount}</strong> ${element.foodUnits} of <strong>${element.foodName}</strong>
                </span>
                <span>
                    <i class="fa fa-edit align-items-md-end"></i>
                </span>
            </button>
        </div>`;
        });

        list.innerHTML = html;
    }
}
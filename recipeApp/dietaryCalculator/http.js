export class httpReq {
    constructor() {
        this.dataForStorage = [];
        this.dataSum = {};
    }

    createUrl(ingr) {
        const parser = ingr.replace(/\s/, "%20");
        const appId = "269a9e34";
        const appKey = "b4e55ae76e078e94edd07e2370f6860e";
        const getUrl = `https://api.edamam.com/api/food-database/v2/parser?ingr=${parser}&app_id=${appId}&app_key=${appKey}`;
        return getUrl;
    }

    async loadFromLS() {
        let fetchData;
        if (localStorage.getItem("fetchData") === null) {
            fetchData = [];
        } else {
            fetchData = JSON.parse(localStorage.getItem("fetchData"));
        }
        this.dataForStorage = fetchData;
    }
    async updateLS() {
        localStorage.setItem("fetchData", JSON.stringify(this.dataForStorage));
    }

    async UpdateSumData() {
        this.loadFromLS();

        let data = { calories: 0, carbs: 0, fat: 0, fiber: 0, protein: 0 };
        this.dataForStorage.forEach((item) => {
            data.calories += parseFloat(item.calories);
            data.carbs += parseFloat(item.carbs);
            data.fat += parseFloat(item.fat);
            data.fiber += parseFloat(item.fiber);
            data.protein += parseFloat(item.protein);
        });

        this.dataSum = data;
        this.setNutritionValues(
            this.dataSum.calories,
            this.dataSum.protein,
            this.dataSum.carbs,
            this.dataSum.fat,
            this.dataSum.fiber,
        );
    }

    clearData() {
        this.dataForStorage = [];
    }

    async setData(id, response, ingr, amount) {
        const data = {};
        data.id = id;
        data.requestSent = ingr;
        data.getData = response;
        data.foodId = response.foodId;
        data.amount = response.amount;

        data.calories =
            (parseFloat(response.nutrients.ENERC_KCAL) * amount) / 100;
        data.carbs = (parseFloat(response.nutrients.CHOCDF) * amount) / 100;
        data.fat = (parseFloat(response.nutrients.FAT) * amount) / 100;
        data.fiber = (parseFloat(response.nutrients.FIBTG) * amount) / 100;
        data.protein = (parseFloat(response.nutrients.PROCNT) * amount) / 100;

        this.dataForStorage.push(data);
        this.updateLS();
    }
    async removeDataItem(id) {
        const ids = this.dataForStorage.map((item) => {
            return item.id;
        });
        const index = ids.indexOf(id);
        this.dataForStorage.splice(index, 1);
        this.updateLS();
        this.UpdateSumData();
    }

    async setNutritionValues(calories, protein, carbs, fat, fiber) {
        document.getElementById("calories-gained").value = calories.toFixed(2);
        document.getElementById("prot-gained").value = protein.toFixed(2);
        document.getElementById("carbs-gained").value = carbs.toFixed(2);
        document.getElementById("fat-gained").value = fat.toFixed(2);
        document.getElementById("fiber-gained").value = fiber.toFixed(2);
    }

    async get(id, ingr, amount) {
        const url = this.createUrl(ingr);
        const response = await fetch(url);
        const resData = await response
            .json()
            .then((response) => {
                this.setData(id, response.hints[0].food, ingr, amount);
                this.UpdateSumData();
            })
            .catch((e) => {
                console.log(e);
            });
    }
}
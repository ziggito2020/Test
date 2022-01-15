<template>
    <div class="exercise-page" >
        <button  @click="download">Download File</button>
        <div>
            <div class="header-container">
                <h2>Countries</h2>
                <button  @click="addCountry">Add Country</button>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>Country</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="country in countries" :key="country.id">
                    <td>{{ country.name }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div>
            <div class="header-container">
                <h2>Cities</h2>
                <button @click="addCity">Add City</button>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>City Name</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="city in cities" :key="city.id">
                    <td>{{ city.name }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div>
            <div class="header-container">
                <h2>Locations</h2>
                <button @click="addLocation">Add Location</button>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>Location Name</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="location in locations" :key="location.id">
                    <td>{{ location.name }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <add-modal :option="modalOption" :open="open" @closeModal="closeModal" />
    </div>
</template>

<script>
import addModal from "../modals/addModal";
import axios from 'axios'

export default {
    name: "Exercise",
    components: {
        addModal
    },
    data() {
        return {
            open: false,
            modalOption: '',
            countries: [],
            cities: [],
            locations: [],
        }
    },
    created() {
        this.updateTablesInfo();
    },
    methods: {
        addCountry() {
            this.modalOption = 'country'
            this.open = true
        },
        addCity() {
            this.modalOption = 'city'
            this.open = true
        },
        addLocation() {
            this.modalOption = 'location'
            this.open = true
        },
        closeModal(option) {
            this.open = false
            this.modalOption = option
            this.updateTablesInfo()
        },
        async download() {
            const response = await axios( { method: 'get', url: ('/api/countries/txt'), response: 'blob' })
            console.log('response', response.data)
            const blob = new Blob([response.data], { type: "application/txt" });
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = 'file.txt';
            link.click();
            URL.revokeObjectURL(link.href);
        },
        async updateTablesInfo() {
            const {data} = await axios.get('/api/countries/all')
            if (data.status === 'success') {
                this.countries = data.data[0]
                this.cities = data.data[1]
                this.locations = data.data[2]
            } else {
                this.$toast.error(`Something went wrong please try again.`);
            }
        }
    }
}
</script>
<style>
    body {
        height: 100vh;
    }
    .exercise-page {
        padding-top: 100px;
    }
    .header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    table {
        width: 800px;
        border-radius: 4px;
        box-shadow: 0 0 4px 0 rgba(0,0,0,0.22);

    }
    th {
        box-shadow: 0 1px 0 0 #D7D7D7;
    }
    tr:not(:first-child) {
        height: 60px;
        text-align: center;
        box-shadow: 0 -1px 0 0 #D7D7D7;
    }
    tr:first-child {
        height: 60px;
        text-align: center;
    }
    button {
        padding: 10px;
        border: 1px solid rgba(81,180,119,0.96);
        background: rgba(81,180,119,0.86);
        color: white;
        font-weight: 600;
        border-radius: 20px;
    }
    button:hover {
        background: rgba(81,180,119,1);
    }
    button:disabled {
        background: lightgrey;
        border: 1px solid lightgrey;
    }
    .form-buttons {
        display: flex;
        flex-direction: row;
        align-items: center;
        border: none;
        justify-content: space-between;
    }
    .submit-btn {
        min-width: 150px;
    }
    .cancel-btn {
        min-width: 150px;
        border: none;
        background-color: #F5F5F5;
        opacity: 0.9;
        color: #7D7D7D;
        font-weight: 600;
    }
    .cancel-btn:hover {
        background-color: #c4c4c4;
    }
    label {
        font-size: 14px;
        letter-spacing: 0.11px;
        line-height: 24px;
    }
    input, select {
        box-sizing: border-box;
        height: 42px;
        width: 100%;
        border: 1px solid #D7D7D7;
        padding-left: 5px;
        margin-top: 10px;
        margin-bottom: 15px;
    }
    @media only screen and (max-width: 800px) {
        table {
            width: 500px;
        }
    }
</style>

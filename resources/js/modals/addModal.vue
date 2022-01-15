<template>
    <div>
        <div class="overlay" v-if="addCountry || addCity || addLocation"></div>
        <div v-if="addCountry" class="modal" :class="open ? 'openModal' : ''">
            <h2>Add a Country</h2>
            <label>Name of the Country:</label>
            <input type="text" v-model="countryName">
            <div class="form-buttons">
                <button @click="onCancel" class="cancel-btn">Cancel</button>
                <button @click="onSubmitCountry" class="submit-btn">Submit</button>
            </div>
        </div>

        <div v-if="addCity" class="modal" :class="open ? 'openModal' : ''">
            <h2>Add a City</h2>
            <label>Choose a Country:</label>
            <select v-model="selectedCountry">
                <option v-for="country in countries" :value="country.id" v-if="countries.length">
                    {{ country.name }}
                </option>
                <option value="1" v-else>
                    No data available
                </option>
            </select>
            <label >Name of the City:</label>
            <input type="text"  v-model="cityName">
            <div class="form-buttons">
                <button @click="onCancel" class="cancel-btn">Cancel</button>
                <button @click="onSubmitCity" class="submit-btn">Submit</button>
            </div>
        </div>

        <div v-if="addLocation" class="modal" :class="open ? 'openModal' : ''">
            <h2>Add a Location</h2>
            <label >Choose a Country:</label>
            <select v-model="selectedCountry">
                <option v-for="country in countries" :value="country.id" v-if="countries.length">
                    {{ country.name }}
                </option>
                <option value="1" v-else>
                    No data available
                </option>
            </select>
            <label >Choose a City:</label>
            <select v-model="selectedCity">
                <option v-for="city in filteredCities" :value="city.id" v-if="filteredCities.length">
                    {{ city.name }}
                </option>
                <option value="1" v-else>
                    No data available
                </option>
            </select>
            <label >Name of the Location:</label>
            <input type="text"  v-model="locationName">
            <div class="form-buttons">
                <button @click="onCancel" class="cancel-btn">Cancel</button>
                <button @click="onSubmitLocation" class="submit-btn">Submit</button>
            </div>
        </div>
    </div>
</template>

<script>

import axios from "axios";

export default {
    name: "addModal",
    props: {
        option: {
            type: String
        },
        open: {
            type: Boolean
        }
    },
    watch: {
      option() {
          switch (this.option) {
          case 'country':
              this.addCountry = true;
              break;
          case 'city':
              this.addCity = true;
              break;
            case 'location':
              this.addLocation = true;
              break;
          }
      },
        open() {
          if (this.open) {
              this.modalData()
          }
        },
        addCountry() {
            if (!this.addCountry) {
                this.$emit("closeModal", '');
            }
        },
        addCity() {
            if (!this.addCity) {
                this.$emit("closeModal", '');
            }
        },
        addLocation() {
          if (!this.addLocation) {
              this.$emit("closeModal", '');
          }
        },
        selectedCountry() {
          if (this.option === 'location') {
              this.filteredCities = this.cities.filter(
                  city => city.country_id === this.selectedCountry
              )
          }
        }
    },
    data() {
        return {
            addCountry: false,
            addCity: false,
            addLocation: false,
            countries: [],
            cities: [],
            filteredCities: [],
            selectedCountry: null,
            selectedCity: null,
            countryName: '',
            cityName: '',
            locationName: '',
        }
    },
    methods: {
        async modalData() {
            const {data} = await axios.get('/api/countries/all')
            if (data.status === 'success') {
                this.countries = data.data[0]
                this.cities = data.data[1]
                this.filteredCities = this.cities
            } else {
                this.$toast.error(`Something went wrong please try again.`);
            }
        },
        async onSubmitCountry() {
            if (this.countryName === '') {
                this.$toast.warning(`The name of the country is required.`);
            }
            const {data} = await axios.post('/api/countries/add', {
                name: this.countryName
            })
            if (data.status === 'success') {
                this.onCancel()
            }
        },
        async onSubmitCity() {
            if (this.cityName === '' || !this.selectedCountry) {
                this.$toast.warning(`The name of the country and the city name are required.`);
            }
            const {data} = await axios.post('/api/cities/add', {
                country_id: this.selectedCountry,
                name: this.cityName
            })
            if (data.status === 'success') {
                this.onCancel()
            }
        },
        async onSubmitLocation() {
            if (this.locationName === '' || !this.selectedCountry || !this.selectedCity) {
                this.$toast.warning(`The country, the city and the name of the location are required.`);
            }
            const {data} = await axios.post('/api/locations/add', {
                country_id: this.selectedCountry,
                city_id: this.selectedCity,
                name: this.locationName
            })
            if (data.status === 'success') {
                this.onCancel()
            }
        },
        onCancel() {
            this.addCountry = false
            this.addCity = false
            this.addLocation = false
            this.countryName = ''
            this.cityName = ''
            this.locationName = ''
            this.selectedCountry = null
            this.selectedCity = null
        }
    }
}
</script>

<style scoped>
    .modal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 10;
        background: #ffffff;
        padding: 20px;
        border-radius: 4px;
        box-shadow: 0 0 4px 0 rgba(0,0,0,0.2);
        display: none;
    }
    .openModal {
        display: block;
    }
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
    }
    select {
        font-size: 15px;
        line-height: 32px;
    }
</style>

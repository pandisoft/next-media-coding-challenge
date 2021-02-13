<template>
  <div class="product-list">
    <div class="container mx-auto px-6">
      <h3 class="text-gray-700 text-1xl font-medium">
        NextMedia awesome products
      </h3>

      <div class="md:flex items-center justify-between py-2">
        <div class="flex justify-between items-center">
          <span class="mt-3 text-sm text-gray-500"
            >{{ totalProducts }} Products, {{ products.length }} shown</span
          >
        </div>
        <div class="flex flex-col md:flex-row -mx-2">
          <div class="my-2 flex sm:flex-row flex-col">
            <div class="flex flex-row mb-1 sm:mb-0">
              <div class="relative">
                <select
                  v-model="filterBy.productField"
                  @change="sortProducts()"
                  class="appearance-none h-full rounded-l border block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                >
                  <option disabled selected>Sort by</option>
                  <option value="price_asc">Price: low to high</option>
                  <option value="price_desc">Price: high to low</option>
                </select>
                <div
                  class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                >
                  <svg
                    class="fill-current h-4 w-4"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                  >
                    <path
                      d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                    />
                  </svg>
                </div>
              </div>
              <div class="relative">
                <select
                  @change="filterByCategory()"
                  v-model="filterBy.productCategory"
                  class="appearance-none h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500"
                >
                  <option disabled selected value="all">All Categories</option>
                  <option
                    v-for="(category, index) in categories"
                    v-bind:key="index"
                    :value="category.id"
                  >
                    {{ category.name }}
                  </option>
                </select>
                <div
                  class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                >
                  <svg
                    class="fill-current h-4 w-4"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                  >
                    <path
                      d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                    />
                  </svg>
                </div>
              </div>
            </div>
            <div class="block relative">
              <span
                class="h-full absolute inset-y-0 left-0 flex items-center pl-2"
              >
                <svg
                  viewBox="0 0 24 24"
                  class="h-4 w-4 fill-current text-gray-500"
                >
                  <path
                    d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z"
                  ></path>
                </svg>
              </span>
              <input
                placeholder="Search ( not working )"
                class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none"
              />
            </div>
          </div>
        </div>
      </div>

      <nm-preloader v-if="isLoading" />
      <div v-else>

        <nm-empty-state v-if="products.length == 0" text="No products yet" />
        <div v-else>
          <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 mt-6">
            <single
              v-for="(product, index) in products"
              v-bind:key="index"
              :product="product"
            ></single>
          </div>

          <nm-preloader v-if="isLoadingMore" />
          <div v-else>
            <div
              class="inline-flex mt-2 xs:mt-0"
              v-if="nextPage && products.length">
              <button
                @click="loadProducts()"
                class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                Load more
              </button>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</template>

<script>
import single from "./Single.vue";
import axios from "axios";

export default {
  data() {
    return {
      isLoading: true,
      isLoadingMore: false,
      totalProducts: 0,
      products: [],
      nextPage: this.$baseURL + "products/list",
      orderType: "id",
      orderDirection: "desc",
      categories: [],
      filterBy: {
        productField: "price_desc",
        productCategory: "all",
      },
    };
  },
  components: {
    single,
  },
  beforeMount() {
    this.loadProducts();
    this.loadCategories();
  },
  methods: {
    loadProducts() {
      axios
        .post(this.nextPage, {
          order_type: this.orderType,
          order_direction: this.orderDirection,
          category: this.filterBy.productCategory,
        })
        .then((r) => {
          let response = r.data;
          if (response.status == "ok") {
            this.products = this.products.concat(response.products.data);
            this.totalProducts = response.products.total;
            this.nextPage = response.products.next_page_url;
          }
          this.isLoading = false;
        })
        .catch((r) => {
          alert(r.message);
        });
    },
    loadCategories() {
      axios
        .post(this.$baseURL + "categories/list")
        .then((r) => {
          let response = r.data;
          if (response.status == "ok") {
            this.categories = response.categories;
          }
        })
        .catch((r) => {
          alert(r.message);
        });
    },
    sortProducts() {
      (this.isLoading = true),
        (this.totalProducts = 0),
        (this.products = []),
        (this.nextPage = this.$baseURL + "products/list"),
        (this.orderType = this.getSelectedOrderBy(0)),
        (this.orderDirection = this.getSelectedOrderBy(1)),
        this.loadProducts();
    },
    filterByCategory() {
      (this.isLoading = true),
        (this.totalProducts = 0),
        (this.products = []),
        (this.nextPage = this.$baseURL + "products/list"),
        this.loadProducts();
    },
    getSelectedOrderBy(index) {
      // Split the string into 2 parts ( Order field name and order direction)
      return this.filterBy.productField.split("_")[index];
    },
  },
};
</script>
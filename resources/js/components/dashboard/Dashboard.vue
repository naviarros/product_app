<template>
    <div class="wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
          </li>
        </ul>
      </nav>

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
                <router-link to="/" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>Dashboard</p>
                </router-link>
              </li>
              <!-- Add more menu items here -->
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <router-link to="/create_product" class="btn btn-primary"><p>Create Product</p></router-link>
              </div>
            </div>
          </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
          <div class="container-fluid">
            <router-view></router-view>
            <div class="col-sm-6">
              <input v-model="searchKeyword" type="text" class="form-control" placeholder="Search by Name or Description">
            </div>
            <div class="card mt-3">
                <div class="card-body">
                <h4 class="card-title">Product Table</h4>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Images</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Date Created</th>
                        <th>Date Updated</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <!-- Use v-for to iterate over the fetched data and populate the table rows -->
                        <tr v-for="product in products['data']" :key="product.id">
                          <td>{{ product ? product.name : '' }}</td>
                          <td>{{ product ? product.category : '' }}</td>
                          <td>
                            {{ console.log(product.images) }}
                            <img v-if="product && product.images" :src="product.images" alt="Product Image" style="max-width: 200px; max-height: 200px;">
                            <span v-else>No Image</span>
                          </td>
                          <td>{{ product ? product.description : '' }}</td>
                          <td>{{ product ? product.date_time : '' }}</td>
                          <td>{{ product ? product.date_created : '' }}</td>
                          <td>{{ product ? product.date_updated : '' }}</td>
                          <td>
                            <!-- Add any action buttons or links here -->
                            <router-link :to="{ path: `/edit_product/${product.id}`}" class="btn btn-primary">Edit</router-link>
                            <button @click="deleteProduct(product.id)" class="btn btn-danger">Delete</button>
                          </td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
          </div>
        </div>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
          Version 1.0
        </div>
        <!-- Default to the left -->
        <strong>AdminLTE Dashboard &copy; 2022</strong>
      </footer>
    </div>
  </template>

<script>
import axios from 'axios';
import { onMounted, ref, computed, watch } from 'vue';
import { useRouter } from 'vue-router';



export default {
  name: "dashboard",
  setup() {
    const products = ref([]);
    const searchKeyword = ref('');
    const router = useRouter();

    // Method to fetch data from the main endpoint
    const fetchData = async () => {
      try {
        const response = await axios.get('/api/products', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            // Other headers if needed
          },
        });

        // Update the products data with the fetched data
        products.value = response.data;
      } catch (error) {
        console.error('Failed to fetch products', error);
      }
    };

    // Method to fetch data from the 'show' endpoint (for a different purpose)
    const fetchOtherData = async () => {
      try {
        const response = await axios.get('/api/products/show', {
          params: {
            search: searchKeyword.value,
          },
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            // Other headers if needed
          },
        });

        // Do something with the data if needed
        products.value = response.data;
      } catch (error) {
        console.error('Failed to fetch other data', error);
      }
    };

    // Fetch initial data on component mount
    onMounted(async () => {
      await fetchData();
    });

    // Watch for changes in the searchKeyword and trigger the fetchOtherData method
    watch(searchKeyword, () => {
      fetchOtherData();
    });

    // Computed property to filter products based on the search keyword
    const filteredProducts = computed(() => {
      // Check if products.value is an array before using the filter function
      if (!Array.isArray(products.value)) {
        return [];
      }

      const search = searchKeyword.value.toLowerCase();

      return products.value.filter(product => {
        return (
          product.name.toLowerCase().includes(search) ||
          product.description.toLowerCase().includes(search)
        );
      });
    });

    const editProduct = async (productId) => {
        try {
            const response = await axios.get(`/api/products/edit/${productId}`, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    // Other headers if needed
                },
            })

            router.push({ name: 'edit_product', params: { id: productId } });
        } catch (error) {
            console.error('Failed to fetch product', error);
        }
    }

    const deleteProduct = async (productId) => {
      try {
        const response = await axios.delete(`/api/products/delete/${productId}`, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            // Other headers if needed
          },
        });

        // Log the success message from the server
        console.log(response.data);

        // Update the products data after deletion
        await fetchData();
      } catch (error) {
        console.error('Failed to delete product', error);
      }
    };

    return { products, searchKeyword, filteredProducts, editProduct, deleteProduct};
  }
};
</script>

<style>
/* Add any custom styles here */
</style>

<template>
    <div>
      <h2>Edit Product</h2>

      <!-- Your edit product form goes here -->
      <form @submit.prevent="updateProduct" enctype="multipart/form-data">
        <!-- Product Name -->
        <div class="form-group">
          <label for="productName">Product Name</label>
          <input v-model="model.products.name" type="text" class="form-control" id="productName" required>
        </div>

        <!-- Product Category (Assuming it's a select input) -->
        <div class="form-group">
          <label for="productCategory">Product Category</label>
          <select v-model="model.products.category" class="form-control" id="productCategory" required>
            <!-- Options for categories go here -->
            <option value="category1">Category 1</option>
            <option value="category2">Category 2</option>
            <!-- Add more options as needed -->
          </select>
        </div>

        <!-- Product Description (Assuming it's a textarea) -->
        <div class="form-group">
          <label for="productDescription">Product Description</label>
          <textarea v-model="model.products.description" class="form-control" id="productDescription" required></textarea>
        </div>

        <!-- Product Images (Assuming it's a file input allowing multiple files) -->
        <div class="form-group">
          <label for="productImages">Product Images</label>
          <input @change="handleFileChange" type="file" class="form-control" id="productImages" multiple>
        </div>

        <!-- Product Date and Time (Assuming it's a date-time picker) -->
        <div class="form-group">
          <label for="productDateTime">Product Date</label>
          <!-- Use the native date input type for date picker -->
          <input v-model="model.products.date_time" type="date" class="form-control" id="productDateTime" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update Product</button>
      </form>
    </div>
  </template>

<script>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

export default {
  setup() {
    const route = useRoute();
    const router = useRouter();
    const productId = ref();
    const model = ref({
      products: {
        id: null,
        name: '',
        category: '',
        description: '',
        date_time: '',
        images: [], // Assuming images is an array
      },
    });

    const fetchProductDetails = async () => {
      try {
        const response = await axios.get(`/api/products/edit/${productId.value}`, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            // Other headers if needed
          },
        });
        model.value.products = response.data.data;
        console.log('Product Details:', model.value.products);
      } catch (error) {
        console.error('Failed to fetch product details', error);
      }
    };

    const updateProduct = async () => {
      try {
        const { id, name, category, description, date_time, images } = model.value.products;

        const requestData = {
          id,
          name,
          category,
          description,
          date_time,
          images, // Assuming images is an array
        };

        const response = await axios.put(`/api/products/update/${id}`, requestData, {
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            // Other headers if needed
          },
        });

        console.log('Server Response:', response.data);

        // Check for success or handle the response accordingly
        if (response.data.success) {
          console.log('Product updated successfully');
          router.push({ name: 'dashboard' });
        } else {
          console.error('Failed to update product:', response.data.message);
        }

        console.log('After Update - Product ID:', model.value.products.id);
        console.log('After Update - Product:', model.value.products);
      } catch (error) {
        console.log('Failed to update product', error);
      }
    };

    // Fetch product details on component mount
    onMounted(() => {
      productId.value = route.params.id; // Set the initial value from route params
      console.log('Component Mounted - Initial Product ID:', productId.value);
      fetchProductDetails();
    });

    return {
      productId,
      model,
      fetchProductDetails,
      updateProduct,
    };
  },
};
</script>

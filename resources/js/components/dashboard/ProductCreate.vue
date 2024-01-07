<template>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create Product</h3>
              </div>

              <div class="card-body">
                <!-- Your product creation form goes here -->
                <form @submit.prevent="createProduct" enctype="multipart/form-data">
                  <!-- Product Name -->
                  <div class="form-group">
                    <label for="productName">Product Name</label>
                    <input v-model="productName" type="text" class="form-control" id="productName" placeholder="Enter product name" required>
                  </div>

                  <!-- Product Category (Assuming it's a select input) -->
                  <div class="form-group">
                    <label for="productCategory">Product Category</label>
                    <select v-model="productCategory" class="form-control" id="productCategory" required>
                      <!-- Options for categories go here -->
                      <option value="category1">Category 1</option>
                      <option value="category2">Category 2</option>
                      <!-- Add more options as needed -->
                    </select>
                  </div>

                  <!-- Product Description (Assuming it's a textarea) -->
                  <div class="form-group">
                    <label for="productDescription">Product Description</label>
                    <textarea v-model="productDescription" class="form-control" id="productDescription" placeholder="Enter product description" required></textarea>
                  </div>

                  <!-- Product Images (Assuming it's a file input allowing multiple files) -->
                  <div class="form-group">
                    <label for="productImages">Product Images</label>
                    <input @change="handleFileChange" type="file" class="form-control" id="productImages" multiple required>
                  </div>

                  <!-- Product Date and Time (Assuming it's a date-time picker) -->
                  <div class="form-group">
                    <label for="productDateTime">Product Date</label>
                    <!-- Use the native date input type for date picker -->
                    <input v-model="productDateTime" type="date" class="form-control" id="productDateTime" required>
                  </div>

                  <!-- Submit Button -->
                  <button type="submit" class="btn btn-primary">Create Product</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>

<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
  setup() {
    const productName = ref('');
    const productCategory = ref('');
    const productDescription = ref('');
    const productImages = ref([]);
    const productDateTime = ref('');

    const router = useRouter();

    const handleFileChange = (event) => {
      // Update productImages with the selected files
      productImages.value = event.target.files;
    };

    const createProduct = async () => {
      try {
        const formData = new FormData();

        // Append form data, including files, to FormData
        formData.append('name', productName.value);
        formData.append('category', productCategory.value);
        formData.append('description', productDescription.value);
        formData.append('date_time', productDateTime.value);

        // Append multiple files
        for (let i = 0; i < productImages.value.length; i++) {
          formData.append('images[]', productImages.value[i]);
        }

        const response = await axios.post('/api/products/create', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            // Other headers if needed
          },
        });

        console.log('Product created:', response.data);

        // Redirect to the dashboard route after successful product creation
        router.push({ name: 'dashboard' }); // Replace 'dashboard' with your actual route name
      } catch (error) {
        console.error('Failed to create product', error);
      }
    };

    return { productName, productCategory, productDescription, productImages, productDateTime, handleFileChange, createProduct };
  },
};
</script>

  <style scoped>
  /* Add any custom styles for your form here */
  </style>

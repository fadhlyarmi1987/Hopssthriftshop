<template>
  <div class="card">
    <div class="card-body">
      <h2 class="text-center">Register</h2>
      <form @submit.prevent="handleSubmit">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input
            type="text"
            class="form-control"
            id="name"
            v-model="form.name"
            required
          />
          <div v-if="errors.name" class="text-danger">{{ errors.name }}</div>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input
            type="email"
            class="form-control"
            id="email"
            v-model="form.email"
            required
          />
          <div v-if="errors.email" class="text-danger">{{ errors.email }}</div>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input
            type="password"
            class="form-control"
            id="password"
            v-model="form.password"
            required
          />
          <div v-if="errors.password" class="text-danger">{{ errors.password }}</div>
        </div>
        <div class="mb-3">
          <label for="password_confirmation" class="form-label">
            Confirm Password
          </label>
          <input
            type="password"
            class="form-control"
            id="password_confirmation"
            v-model="form.password_confirmation"
            required
          />
          <div
            v-if="errors.password_confirmation"
            class="text-danger"
          >
            {{ errors.password_confirmation }}
          </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">
          Register
        </button>
        <div class="mt-3 text-center">
          <p>Sudah punya akun? <a href="/login" class="text-primary">Klik Di Sini</a></p>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { reactive, ref } from "vue";
import axios from "axios";

export default {
  name: "RegisterPage",
  setup() {
    // Form state
    const form = reactive({
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
    });

    // Error state
    const errors = ref({});

    // Submit form
    const handleSubmit = async () => {
      try {
        // Clear previous errors
        errors.value = {};

        // Send data to backend
        const response = await axios.post("/register", form);

        // Handle success (e.g., redirect or show message)
        alert("Registration successful!");
        window.location.href = "/login";
      } catch (error) {
        if (error.response && error.response.data) {
          // Set errors from response
          errors.value = error.response.data.errors || {};
        } else {
          alert("An error occurred. Please try again.");
        }
      }
    };

    return {
      form,
      errors,
      handleSubmit,
    };
  },
};
</script>

<style scoped>
.card {
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  background-color: #343a40;
  color: white;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}
.card .form-label {
  color: #ddd;
}
.card .text-danger {
  font-size: 0.9em;
}
.text-center a {
  text-decoration: none;
}
</style>

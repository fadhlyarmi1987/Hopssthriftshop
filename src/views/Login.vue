<template>
  <div class="card">
    <div class="card-body">
      <h2 class="text-center">Login</h2>
      <form @submit.prevent="handleLogin">
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
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
      <div class="mt-3 text-center">
        <p>
          Tidak punya akun?
          <a href="/register" class="text-primary">Registrasi di sini.</a>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import { reactive, ref } from "vue";
import axios from "axios";

export default {
  name: "LoginPage",
  setup() {
    // Form state
    const form = reactive({
      email: "",
      password: "",
    });

    // Error state
    const errors = ref({});

    // Handle login
    const handleLogin = async () => {
      try {
        // Clear previous errors
        errors.value = {};

        // Send login request to backend
        const response = await axios.post("/login", form);

        // Handle success (e.g., save token and redirect)
        alert("Login successful!");
        window.location.href = "/dashboard";
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
      handleLogin,
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

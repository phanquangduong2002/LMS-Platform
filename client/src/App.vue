<template>
  <div>Client</div>
</template>

<script>
import axios from "axios";
export default {
  setup() {
    const testApi = async () => {
      try {
        const res = await axios.post("http://localhost:8000/api/user/signup", {
          username: "admin1",
          name: "phan quang duong",
          email: "quangduongsayhi@gmail.com",
          password: "12345",
          password_confirmation: "12345",
        });

        console.log(res);
      } catch (error) {
        console.log(error);
      }
    };

    testApi();
  },
};
</script>

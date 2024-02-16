<template>
  <div class="navbar p-3 font-medium border-b border-seperate">
    <div class="navbar-start">
      <div class="dropdown">
        <div
          tabindex="0"
          role="button"
          class="btn bg-white border-white lg:hidden"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h8m-8 6h16"
            />
          </svg>
        </div>
        <ul
          tabindex="0"
          class="menu menu-sm dropdown-content mt-3 z-[1000] p-2 shadow bg-base-100 rounded-box w-52 font-semibold"
        >
          <li><router-link :to="{ name: 'home' }">Home</router-link></li>
          <li>
            <router-link :to="{ name: 'course-list' }">Courses</router-link>
            <ul class="p-2">
              <li><a>Pratice IELTS</a></li>
              <li><a>Pratice TOEIC</a></li>
            </ul>
          </li>
          <li><a>Tutorials</a></li>
          <li><a>Blogs</a></li>
        </ul>
      </div>
      <router-link
        :to="{ name: 'home' }"
        class="h-[3rem] min-w-[3rem] cursor-pointer px-4 text-xl"
      >
        <img
          src="../../assets/images/logo.webp"
          alt="Logo"
          class="w-full h-full object-contain object-center"
        />
      </router-link>
    </div>
    <div class="navbar-center hidden lg:flex">
      <!-- <ul class="menu menu-horizontal px-1 text-base">
        <li>
          <router-link
            :to="{ name: 'home' }"
            class="hover:text-primary hover:bg-white"
            >Home</router-link
          >
        </li>
        <li>
          <details>
            <summary class="hover:text-primary hover:bg-white">
              <a>Courses</a>
            </summary>
            <ul class="p-2 min-w-[300px]">
              <li><a>NextJS</a></li>
              <li><a>ReactJS</a></li>
            </ul>
          </details>
        </li>
        <li><a class="hover:text-primary hover:bg-white">Tutorials</a></li>
        <li><a class="hover:text-primary hover:bg-white">Blogs</a></li>
      </ul> -->
      <ul class="flex items-center justify-center px-1 text-base gap-2">
        <li
          class="px-2 cursor-pointer hover:text-primary transition-all duration-300"
        >
          <router-link :to="{ name: 'home' }" class="">Home</router-link>
        </li>
        <li
          class="relative px-2 cursor-pointer group hover:text-primary after:absolute after:content after:-bottom-[20px] after:left-0 after:w-full after:h-[32px] after:bg-transparent"
        >
          <router-link :to="{ name: 'course-list' }"
            >Courses
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="16px"
              height="16px"
              viewBox="0 0 24 24"
              fill="none"
              class="inline-block group-hover:rotate-180 transition-all duration-300"
            >
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M4.29289 8.29289C4.68342 7.90237 5.31658 7.90237 5.70711 8.29289L12 14.5858L18.2929 8.29289C18.6834 7.90237 19.3166 7.90237 19.7071 8.29289C20.0976 8.68342 20.0976 9.31658 19.7071 9.70711L12.7071 16.7071C12.3166 17.0976 11.6834 17.0976 11.2929 16.7071L4.29289 9.70711C3.90237 9.31658 3.90237 8.68342 4.29289 8.29289Z"
                fill="currentColor"
              />
            </svg>
          </router-link>
          <ul
            class="absolute -bottom-[100px] left-0 hidden group-hover:flex flex-col gap-4 z-[1] menu p-4 shadow bg-base-100 rounded-box w-52 text-gray"
          >
            <li
              class="px-2 cursor-pointer hover:text-primary transition-all duration-300"
            >
              Practice IELTS
            </li>
            <li
              class="px-2 cursor-pointer hover:text-primary transition-all duration-300"
            >
              Practice TOEIC
            </li>
          </ul>
        </li>
        <li
          class="px-2 cursor-pointer hover:text-primary transition-all duration-300"
        >
          Tutorials
        </li>
        <li
          class="px-2 cursor-pointer hover:text-primary transition-all duration-300"
        >
          Blogs
        </li>
      </ul>
    </div>
    <div class="navbar-end gap-3 pr-4">
      <router-link
        :to="{ name: 'auth-login' }"
        class="px-4 py-2 rounded-md bg-gradient text-white text-sm cursor-pointer"
        >Login</router-link
      >
      <router-link
        :to="{ name: 'auth-register' }"
        class="px-4 py-2 rounded-md bg-gradient text-white text-sm cursor-pointer"
        >Register</router-link
      >
    </div>
  </div>
</template>

<script>
export default {}
</script>

<style></style>

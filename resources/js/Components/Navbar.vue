<template>
    <nav class="flex justify-between p-4 bg-gray-200 ">
        <div class="text-lg ">
            MyWardrobe
        </div>
        <div>
            <ul class="flex gap-x-4 me-auto mb-2 mb-lg-0">
                <li>
                    <Link class="text-dark" :href="route('profile.edit')">  {{ $page.props.auth.user.name }}</Link>
                </li>
                <li>
                    <Link class="text-dark" method="post" :href="route('logout')" as="button">Logout</Link>
                </li>
            </ul>
        </div>
    </nav>
</template>
<script setup>
import { Link } from '@inertiajs/vue3';
</script>
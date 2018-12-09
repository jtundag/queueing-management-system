<template>
    <form action="#" @submit.prevent="$emit('submit', $event)">
        <slot/>
    </form>
</template>

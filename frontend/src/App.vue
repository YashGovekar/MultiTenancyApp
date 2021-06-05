<template>
  <div>
    <inertia-head :title="title" />
    <slot />
  </div>
</template>

<script>
export default {
  props: {
    title: String,
  }
}
</script>

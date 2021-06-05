<template>
  <app title="Home">
    <dashboard-layout>
      <b-row>
        <b-col cols="12">
          <b-card no-body>
            <b-card-header class="border-0">
              <h3 class="mb-0">Welcome To a Multi-Tenancy App</h3>
            </b-card-header>

            <b-card-footer class="py-4 d-flex justify-content-end">
            </b-card-footer>
          </b-card>
        </b-col>
      </b-row>
    </dashboard-layout>
  </app>
</template>

<script>
import App from '@/App';
import DashboardLayout from "@/views/Layout/DashboardLayout";
import {BButton, BCol, BRow} from "bootstrap-vue";

export default {
  name: "Home",
  props: {

  },
  components: {
    App,
    BRow,
    BCol,
    BButton,
    DashboardLayout,
  },
  data() {
    return {

    };
  },
  methods: {
    saveTablesToExclude() {
      this.$inertia.post(route('admin.tables-to-exclude.update'), {
        '_method': 'patch',
        'tables_to_exclude': this.checked,
      }, {
        onSuccess: () => {
          this.$notify({verticalAlign: 'bottom', horizontalAlign: 'right', message: 'Data Saved!'});
        }
      })
    }
  },
  mounted() {

  }
}
</script>

<style scoped>

</style>

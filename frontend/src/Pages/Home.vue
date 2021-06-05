<template>
  <app title="Home">
    <dashboard-layout>
      <b-row>
        <b-col cols="7">
          <b-card no-body>
            <b-card-header class="border-0">
              <h3 class="mb-0">Tables To Exclude During Customer Registration</h3>
            </b-card-header>

            <el-table class="table-responsive table"
                      header-row-class-name="thead-light"
                      :data="db_tables">
              <el-table-column label="Tables"
                               prop="name">
              </el-table-column>
              <el-table-column label="Exclude?">
                <template v-slot="{row}">
                  <badge class="badge-dot mr-4" type="">
                    <input type="checkbox" :value="row.name" v-model="checked" />
                  </badge>
                </template>
              </el-table-column>
            </el-table>

            <b-card-footer class="py-4 d-flex justify-content-end">
              <base-pagination v-model="currentPage" :per-page="10" :total="db_tables.length"></base-pagination>
            </b-card-footer>
            <b-button @click="saveTablesToExclude" variant="success">
              Save
            </b-button>
          </b-card>
        </b-col>
        <b-col cols="5">
          <b-card no-body>
            <b-card-header class="border-0">
              <h3 class="mb-0">All Customers</h3>
            </b-card-header>

            <el-table class="table-responsive table"
                      header-row-class-name="thead-light"
                      :data="customers">
              <el-table-column label="Name"
                               prop="name">
              </el-table-column>
              <el-table-column label="Email"
                               prop="email">
              </el-table-column>
              <el-table-column label="Subdomain"
                               prop="subdomain">
              </el-table-column>
            </el-table>

            <b-card-footer class="py-4 d-flex justify-content-end">
              <base-pagination v-model="customersCurrentPage" :per-page="10" :total="customers.length"></base-pagination>
            </b-card-footer>
          </b-card>
        </b-col>
      </b-row>
    </dashboard-layout>
  </app>
</template>

<script>
import App from '../App';
import DashboardLayout from "@/views/Layout/DashboardLayout";
import {Table, TableColumn} from "element-ui";
import {BButton, BCol, BRow} from "bootstrap-vue";

export default {
  name: "Home",
  props: {
    db_tables: Array,
    tables_to_exclude: Array,
    customers: Array,
  },
  components: {
    App,
    BRow,
    BCol,
    BButton,
    DashboardLayout,
    [Table.name]: Table,
    [TableColumn.name]: TableColumn
  },
  data() {
    return {
      checked: [],
      currentPage: 1,
      customersCurrentPage: 1
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
    this.tables_to_exclude.map(table => {
      this.checked.push(table.name);
    })
  }
}
</script>

<style scoped>

</style>

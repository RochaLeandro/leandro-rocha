<template>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-2">
            <div class="card bg-light">
                <div class="card-body">
                    <h5>Filtros</h5>

                    <hr>

                    <div class="form-group">
                        <label for="search">Pesquisa <small>(nome, e-mail)</small></label>
                        <input type="text" id="search" class="form-control" v-model="search">
                    </div>

                    <div class="form-group">
                        <label for="login">Último login</label>
                        <flat-pickr id="login" class="form-control" :config="fpConfig" v-model.lazy="login"></flat-pickr>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Usuários</h5>
                        </div>

                        <div class="col-auto">
                            <div class="form-group mb-0">
                                <select class="form-control form-control-sm" v-model="limit">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-striped mb-0">
                        <thead>
                            <tr>
                                <th><a href="#" @click.prevent="sort('name')">Nome</a></th>
                                <th><a href="#" @click.prevent="sort('email')">E-mail</a></th>
                                <th class="text-center"><a href="#" @click.prevent="sort('accesses_count')">Nº de logins</a></th>
                                <th class="text-center">Situação</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="u in users" :key="u.id">
                                <td>{{ u.name }}</td>
                                <td>{{ u.email }}</td>
                                <td class="text-center">{{ u.accesses_count }}</td>
                                <td class="text-center">
                                    {{ u.active ? 'Ativo' : 'Inativo' }}
                                </td>
                            </tr>

                            <tr v-if="users.length < 1">
                                <td class="text-center" colspan="4">Nenhum registro encontrado.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    <lr-pagination :source="pagination" @navigate="navigate"></lr-pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .form-control.input:disabled, .form-control.input[readonly] {
        background-color: #fff;
    }
</style>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import LrPagination from './Pagination';

    import 'flatpickr/dist/flatpickr.css';
    import { Portuguese } from 'flatpickr/dist/l10n/pt';

    export default {
        components: {
            flatPickr,
            LrPagination
        },

        data () {
            return {
                users:       [],
                pagination:  {},
                search: '',
                limit:  10,
                page:   1,
                sortProperty: 'name',
                sortDirection: 'asc',
                login: '',
                fpConfig: {
                    altInput:   true,
                    altFormat:  'd/m/Y',
                    dateFormat: 'Y-m-d',
                    mode: 'range',
                    locale: Portuguese
                }
            }
        },

        methods: {
            navigate (page) {
                this.page = page;
            },

            sort (property) {
                this.sortProperty = property;

                this.sortDirection == 'asc' ? this.sortDirection = 'desc' : this.sortDirection = 'asc';

                this.fetchUsers(this.page);
            },

            fetchUsers (page = null) {
                var strPage   = page > 1 ? 'page=' + page : '';
                var strSearch = this.search ? 'search=' + this.search : '';
                var strLogin  = this.login ? 'login=' + this.login : '';

                var queries = '?' + ([strSearch, strPage, strLogin].filter((item) => item != '').join('&'));

                axios.post('/users/fetch' + queries, {
                    limit:          this.limit,
                    sort_property:  this.sortProperty,
                    sort_direction: this.sortDirection
                })
                .then(res => {
                    this.users = res.data.data;

                    this.pagination = res.data;
                })
                .catch(err => {
                    console.log(JSON.stringify(err));
                });
            }
        },

        watch: {
            page () {
                this.fetchUsers(this.page);
            },

            limit () {
                this.fetchUsers();
            },

            search () {
                this.fetchUsers();
            },

            login () {
                setTimeout(() => {
                    this.fetchUsers();
                }, 1000);
            }
        },

        mounted () {
            this.fetchUsers();
        }
    }
</script>
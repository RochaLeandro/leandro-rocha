<template>
    <nav>
        <ul class="pagination justify-content-center mb-0">
            <li :class="[{disabled: source.current_page == 1}, 'page-item']"><a class="page-link" href="#" @click.prevent="navigate(source.current_page - 1)">Anterior</a></li>

            <li v-for="(p, index) in pages" :key="index" :class="[{ active: source.current_page == p }, 'page-item']">
                <span class="page-link" v-if="p == '...'">{{ p }}</span>
                <a class="page-link" href="#" v-else @click.prevent="navigate(p)">{{ p }}</a>
            </li>

            <li :class="[{disabled: source.current_page == source.last_page}, 'page-item']"><a class="page-link" href="#" @click.prevent="navigate(source.current_page + 1)">Próximo</a></li>
        </ul>
    </nav>    
</template>

<script>
    export default {
        props: ['source'],

        data () {
            return {
                pages: []
            }
        },

        methods: {
            navigate (page) {
                this.$emit('navigate', page);
            },

            generatePagesArray (currentPage, collectionLength, rowsPerPage, paginationRange) {
                var pages      = [];
                var totalPages = Math.ceil(collectionLength / rowsPerPage);
                var halfWay    = Math.ceil(paginationRange / 2);
                var position;

                if (currentPage <= halfWay) {
                    position = 'start';
                } else if (totalPages - halfWay < currentPage) {
                    position = 'end';
                } else {
                    position = 'middle';
                }

                var ellipsesNeeded = paginationRange < totalPages;

                var i = 1;

                while (i <= totalPages && i <= paginationRange) {
                    var pageNumber            = this.calculatePageNumber(i, currentPage, paginationRange, totalPages);
                    var openingEllipsesNeeded = (i === 2 && (position === 'middle' || position === 'end'));
                    var closingEllipsesNeeded = (i === paginationRange - 1 && (position === 'middle' || position === 'start'));

                    if (ellipsesNeeded && (openingEllipsesNeeded || closingEllipsesNeeded)) {
                        pages.push('...');
                    } else {
                        pages.push(pageNumber);
                    }

                    i ++;
                }

                return pages;
            },

            calculatePageNumber (i, currentPage, paginationRange, totalPages) {
                var halfWay = Math.ceil(paginationRange / 2);
                
                if (i === paginationRange) {
                    return totalPages;
                } else if (i === 1) {
                    return i;
                } else if (paginationRange < totalPages) {
                    if (totalPages - halfWay < currentPage) {
                        return totalPages - paginationRange + i;
                    } else if (halfWay < currentPage) {
                        return currentPage - halfWay + i;
                    } else {
                        return i;
                    }
                } else {
                    return i;
                }
            }
        },

        watch: {
            source () {
                this.pages = this.generatePagesArray(this.source.current_page, this.source.total, this.source.per_page, 11);
            }
        }
    }
</script>
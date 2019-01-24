<template>
    <div>
        <table class="table-auto mt-5 w-full text-sm">
            <thead class="fez123-border-bottom">
                <tr>
                    <th class="px-4 py-5 font-normal text-left" 
                        v-for="(column, index) in columns"
                        :key="index">
                            <span>
                                {{ column.label }}
                            </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="fez123-border-bottom" 
                    v-for="(rowData, rowIndex) in result"
                    :key="rowIndex">
                    <td class="px-4 py-3" 
                        v-for="(colData, colIndex) in columns"
                        :key="colIndex">
                        <span v-if="!colData.slot">
                            {{ rowData[colData.name] }}
                        </span>
                        <slot :name="colData.slot" :row-data="rowData" v-else></slot>
                    </td>
                </tr>
                <tr class="fez123-border-bottom"
                    v-if="!result.length">
                    <td class="px-4 py-3 text-center" colspan="6">
                        No Result(s).
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- <div class="mt-5 text-right">
            <Pagination/>
        </div> -->
    </div>
</template>

<script>
export default {
    props: {
        columns: {
            type: Array,
            required: true
        },
        api: {
            type: String,
            default: null
        },
        data: {
            type: Array,
            default: null
        },
        config: {
            type: Object,
            default: () => ({
                per_page: 10
            })
        },
        customParams: {
            type: Object,
            default: () => ({})
        }
    },
    created(){
        if(this.api) this.loadData()
    },
    data(){
        return {
            result: this.data || [],
            currentPage: 1,
            count: 0
        }
    },
    methods: {
        loadData(){
            this.$emit('before-load')
            this.$http.get(this.api, {
                params: {
                    per_page: this.config.per_page,
                    current_page: this.currentPage,
                    ...this.customParams
                }
            })
                .then((response) => {
                    this.result = response.data.result
                    this.$emit('after-load')
                })
        }
    }
}
</script>

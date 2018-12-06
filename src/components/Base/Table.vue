<template>
    <table class="table-auto mt-5 w-full text-sm">
        <thead class="fez123-border-bottom">
            <tr>
                <th class="px-4 py-5 font-normal text-left" 
                    v-for="(column, index) in columns"
                    :key="index">
                        <span v-if="!column.slot">
                            {{ column.label }}
                        </span>
                        <span v-else>&nbsp;</span>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="fez123-border-bottom" 
                v-for="(rowData, rowIndex) in data"
                :key="rowIndex">
                <td class="px-4 py-5" 
                    v-for="(colData, colIndex) in rowData"
                    :key="colIndex">
                    <span>
                        {{ colData }}
                    </span>
                </td>
                <td class="px-4 py-5" 
                    v-for="(slotName, slotIndex) in slots"
                    :key="slotIndex">
                    <slot :name="slotName" :row-data="rowData"></slot>
                </td>
            </tr>
            <tr class="fez123-border-bottom"
                v-if="!data.length">
                <td class="px-4 py-5 text-center" colspan="6">
                    No Result(s).
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: {
        columns: {
            type: Array,
            required: true
        },
        data: {
            type: Array,
            required: true
        }
    },
    created(){
        this.slots = _.filter(_.map(this.columns, 'slot'), (col) => col)
    },
    data(){
        return {
            slots: []
        }
    },
    methods: {
        isSlot(col){
            return _.findIndex(this.slots, col) !== -1
        }
    }
}
</script>

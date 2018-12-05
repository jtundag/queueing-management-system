<template>
    <table class="table-auto mt-5 w-full text-sm">
        <thead class="fez123-border-bottom">
            <tr>
                <th class="px-4 py-5 font-normal text-left" 
                    v-for="(column, index) in columns"
                    :key="index">
                        {{ column.label }}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="fez123-border-bottom" 
                v-for="(rowData, index) in data"
                :key="index">
                <td class="px-4 py-5" 
                    v-for="(rowCol, index) in rowData"
                    :key="index">
                    <slot v-if="index == 'slot' && rowCol" :name="rowCol" :row-data="rowData"/>
                    <span v-else>
                        {{ rowCol }}
                    </span>
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
    }
}
</script>

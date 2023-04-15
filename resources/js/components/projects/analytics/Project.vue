<script>
import { optionChart } from "../../../helpers/chart";
export default {
    props: {
        results: {
            type: Object,
            default: () => {
                return {}
            },
        },
        title: {
            type: String,
            default: () => {
                return ""
            },
        },
    },
    data() {
        return {
            series: [],
            chartOption: {},
            data: {}
        };
    },
    computed: {},
    methods: {
        options:() => optionChart.optionProject(),
    },
    watch: {
        results: function() {
            this.data = this.$props.results;
            this.chartOption = this.options();
            this.series = [this.results.total];       
            this.chartOption['labels'] = ['Progress'];       
            if (this.data.total == 100) {
                this.chartOption['colors'] = '#7bd405';
                this.chartOption['labels'] = ['Success'];   
            }
        }
    },
};
</script>
<template>
   <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4 text-center">{{ title }}</h4>
            <apexchart                            
                type="radialBar"
                dir="ltr"
                :series="series"
                :options="chartOption"
            ></apexchart>
        </div>                    
    </div>
</template>
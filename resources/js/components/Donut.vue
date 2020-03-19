<script>
import { Doughnut } from 'vue-chartjs'

export default {

	extends: Doughnut,

	props: ['total'],

	data() {
		return {
			totalColor: '',
			options: {
			    legend: {
			        display: false
			    },
				tooltips: {enabled: false},
				hover: {mode: null},
				segmentShowStroke: false,
				responsive: true, 
				maintainAspectRatio: true,
				aspectRatio: 1, 
				animation:
				{
					animateRotate: true
				}
			},

		}
	},

	computed: {
	    color() {
	    	if(this.total >= 80 ) return this.totalColor = '#B8E986';
	    	if(this.total <= 25 ) return this.totalColor = 'red';
	    	if(this.total < 80 && this.total > 25) return this.totalColor = 'orange';
	    }
	},

	mounted () {

		let chartData = {
			labels: ['Résultat'],
			datasets: [
				{
					backgroundColor: [this.color, '#FFF'],
					data: [this.total, this.total - 100],
					borderWidth: [0, 0, 0, 0]
				}
			]
		}

		this.renderChart(chartData, this.options);
		this.textCenter(this.total);
	},

	methods:{

		textCenter(val) {
			let vm = this;
			Chart.pluginService.register({
				beforeDraw: function(chart) {
					var width = chart.chart.width,
					height = chart.chart.height,
					ctx = chart.chart.ctx;

					ctx.restore();
					var fontSize = (height / 114).toFixed(2);
					ctx.font = fontSize + "em sans-serif";
					ctx.textBaseline = "middle";
					ctx.fillStyle = vm.color;

					var text = val + "%",
					textX = Math.round((width - ctx.measureText(text).width) / 2),
					textY = height / 2;

					ctx.fillText(text, textX, textY);
					ctx.save();
				}
			});
		}

	}

}
</script>
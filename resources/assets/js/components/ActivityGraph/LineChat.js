import {Line} from 'vue-chartjs'

export default Line.extend({
  mounted () {
    this.renderChart({
      labels: ['January', 'February', 'March', 'April', 'May', 'June'],
      datasets: [
        {label: 'My activities', backgroundColor: '#dd4b39', data: [40, 39, 31, 11, 45, 50]},
        {label: 'System activities', backgroundColor: '#dddddd', data: [45, 43, 20, 55, 34, 90]},
      ]
    }, {responsive: true, maintainAspectRatio: false})
  }
})
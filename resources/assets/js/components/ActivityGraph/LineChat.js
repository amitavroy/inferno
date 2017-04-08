import axios from 'axios'
import {Line} from 'vue-chartjs'
import {watchdogData} from './../../config'

export default Line.extend({
  mounted () {
    axios.get(watchdogData)
      .then(resp => {
        console.log('resp', resp.data.data)
        this.rows = resp.data.data.rows
        this.labels = resp.data.data.labels
        this.setUpGraph()
      })
  },
  data () {
    return {
      rows: [],
      labels: []
    }
  },
  methods: {
    setUpGraph() {
      this.renderChart({
        labels: this.labels,
        datasets: [
          {label: 'My activities', backgroundColor: '#dd4b39', data: this.rows}
        ]
      }, {responsive: true, maintainAspectRatio: false})
    }
  }
})
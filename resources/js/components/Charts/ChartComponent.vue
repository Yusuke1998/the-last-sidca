<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <canvas id="my-chart-line"></canvas>
      </div>
      <div class="col-6">
        <canvas id="my-chart-bar"></canvas>
      </div>
      <div class="col-6">
        <canvas id="my-chart-barHorizontal"></canvas>
      </div>
    </div>
  </div>
</template>

<script>
  import Chart from 'chart.js';
  export default {
      mounted() {
          this.line()
          this.bar()
          this.barHorizontal()
      },
      methods:{
      line(){
        new Chart(document.getElementById('my-chart-line'), {
          type: 'line',
          data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [
              {
                label: '2019 Nominas',
                data: [300, 700, 450, 750, 450]
              }
            ]
          }
        });
      },
      bar(){
        new Chart(document.getElementById('my-chart-bar'), {
          type: 'bar',
          data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [
              {
                label: '2019 Nominas',
                data: [300, 700, 450, 750, 450]
              }
            ]
          }
        });
      },
      barHorizontal(){
        new Chart(document.getElementById('my-chart-barHorizontal'), {
          type: 'horizontalBar',
          data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [
              {
                label: '2019 Nominas',
                data: [300, 700, 450, 750, 450]
              }
            ]
          }
        });
      }
    }
  }
</script>
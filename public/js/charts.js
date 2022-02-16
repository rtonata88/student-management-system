async function getSubjectsData() {
  let token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute('content');

  const response = await fetch(`/get-subjects`, {
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json, text-plain, */*',
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': token,
    },
    credentials: 'same-origin',
  })
    .then(function (data) {
      return data.json();
    })
    .catch(function (error) {
      console.log(error);
    });

  return response;
}

async function main() {
  const subjectData = await getSubjectsData();

  Highcharts.chart('subjects-pie-chart', {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie',
    },
    title: {
      text: 'Number of registrations per subject',
    },
    tooltip: {
      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>',
    },
    accessibility: {
      point: {
        valueSuffix: '%',
      },
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: true,
          format: '<b>{point.name}</b>: {point.percentage:.1f} %',
        },
      },
    },
    series: [
      {
        name: 'Percentage',
        colorByPoint: true,
        data: subjectData,
      },
    ],
  });
}

window.onload = main;

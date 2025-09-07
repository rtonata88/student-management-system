async function getSubjectsData() {
  let token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute('content');

  try {
    const response = await fetch(`/get-subjects`, {
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json, text-plain, */*',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': token,
      },
      credentials: 'same-origin',
    });

    if (!response.ok) {
      console.error('API request failed:', response.status, response.statusText);
      return [];
    }

    const data = await response.json();
    console.log('Subjects data received:', data);
    return data;
  } catch (error) {
    console.error('Error fetching subjects data:', error);
    return [];
  }
}

async function main() {
  console.log('Initializing pie chart...');
  
  // Check if Highcharts is available
  if (typeof Highcharts === 'undefined') {
    console.error('Highcharts library not loaded');
    document.getElementById('subjects-pie-chart').innerHTML = '<p style="text-align: center; color: red;">Chart library failed to load</p>';
    return;
  }

  const subjectData = await getSubjectsData();
  
  // Check if we have data
  if (!subjectData || subjectData.length === 0) {
    console.warn('No subject data available for chart');
    document.getElementById('subjects-pie-chart').innerHTML = '<p style="text-align: center; color: #666;">No data available for chart</p>';
    return;
  }

  try {
    Highcharts.chart('subjects-pie-chart', {
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie',
      },
      title: {
        text: 'Registrations per subject',
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
    console.log('Pie chart rendered successfully');
  } catch (error) {
    console.error('Error rendering chart:', error);
    document.getElementById('subjects-pie-chart').innerHTML = '<p style="text-align: center; color: red;">Error rendering chart</p>';
  }
}

window.onload = main;

let cardColor, labelColor, headingColor, borderColor, bodyColor;
const movements = getMovements();
const type_movements = getTypeMovements();

$(() => {
    if (isDarkStyle) {
        cardColor = config.colors_dark.cardColor;
        labelColor = config.colors_dark.textMuted;
        headingColor = config.colors_dark.headingColor;
        borderColor = config.colors_dark.borderColor;
        bodyColor = config.colors_dark.bodyColor;
    } else {
        cardColor = config.colors.cardColor;
        labelColor = config.colors.textMuted;
        headingColor = config.colors.headingColor;
        borderColor = config.colors.borderColor;
        bodyColor = config.colors.bodyColor;
    }

    loadChart()
})

async function loadChart(){

    const tm_color = type_movements.find(tm => tm.id == 2).states[0].background.split(' ')[0];

    const colors = await getColors();
    let color = colors.find(c => c.color == tm_color);
    color = color ? color.hex : '#ccc';
    
    const movements_credit = movements.filter(m => m.type_movement_id == 2 && m.payment_method_id == 2 && stateMapping[2].includes(m.state_id));
    
    const total_credits = movements_credit.reduce((acc, m) => {
        acc += parseFloat(m.value);
        return acc;
    }, 0);

    const total_credits_payment = movements_credit.reduce((acc, m) => {
        acc += parseFloat(m.total_x_payable);
        return acc;
    }, 0);

    const percentage_total = total_credits > 0 ? (total_credits_payment * 100) / total_credits : 100;

    const percentage = Math.round(percentage_total);
    

    const overviewChartEl = document.querySelector('#overviewChart'),
    overviewChartConfig = {
      chart: {
        height: 140,
        type: 'radialBar',
        sparkline: {
          enabled: true
        }
      },
      plotOptions: {
        radialBar: {
          hollow: {
            size: '50%'
          },
          dataLabels: {
            name: {
              show: false
            },
            value: {
              show: true,
              offsetY: 5,
              fontWeight: 500,
              fontSize: '1rem',
              fontFamily: 'Inter',
              color: headingColor
            }
          },
          track: {
            background: config.colors_label.secondary
          }
        }
      },
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      },
      stroke: {
        lineCap: 'round'
      },
      colors: [color],
      grid: {
        padding: {
          bottom: -15
        }
      },
      series: [percentage],
      labels: ['Progress']
    };
    if (typeof overviewChartEl !== undefined && overviewChartEl !== null) {
        const overviewChart = new ApexCharts(overviewChartEl, overviewChartConfig);
        overviewChart.render();
    }

    const totalTransactionChartEl = document.querySelector('#totalTransactionChart'),
    totalTransactionChartConfig = {
      chart: {
        height: 218,
        stacked: true,
        type: 'bar',
        parentHeightOffset: 0,
        toolbar: {
          show: false
        }
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return Math.abs(val);
          }
        }
      },
      legend: { show: false },
      dataLabels: { enabled: false },
      colors: [config.colors.primary, config.colors.success],
      grid: {
        borderColor,
        xaxis: { lines: { show: true } },
        yaxis: { lines: { show: false } },
        padding: {
          top: -5,
          bottom: -25
        }
      },
      states: {
        hover: { filter: { type: 'none' } },
        active: { filter: { type: 'none' } }
      },
      plotOptions: {
        bar: {
          borderRadius: 5,
          barHeight: '30%',
          horizontal: true,
          endingShape: 'flat',
          startingShape: 'rounded'
        }
      },
      xaxis: {
        position: 'top',
        axisTicks: { show: false },
        axisBorder: { show: false },
        categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        labels: {
          style: {
            colors: labelColor,
            fontSize: '13px',
            fontFamily: 'Inter'
          },
          formatter: function (val) {
            return Math.abs(Math.round(val));
          }
        }
      },
      yaxis: { labels: { show: false } },
      series: [
        {
          name: 'Last Week',
          data: [83, 153, 213, 279, 213, 153, 83]
        },
        {
          name: 'This Week',
          data: [-84, -156, -216, -282, -216, -156, -84]
        }
      ]
    };
  if (typeof totalTransactionChartEl !== undefined && totalTransactionChartEl !== null) {
    const totalTransactionChart = new ApexCharts(totalTransactionChartEl, totalTransactionChartConfig);
    totalTransactionChart.render();
  }
}
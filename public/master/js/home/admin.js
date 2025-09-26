'use strict';
const projects = getProjects();
const type_movements = getTypeMovements();
let cardColor, labelColor, headingColor, borderColor, bodyColor;

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
    loadMovementsGraph();
    loadSwiper();
    loadChart();
})

async function loadMovementsGraph(){
    const colors = await getColors();

    const salesCountryChartEl = document.querySelector('#graph-movements'),
    salesCountryChartConfig = {
        chart: {
            type: 'bar',
            height: 368,
            parentHeightOffset: 0,
            toolbar: {
                show: false
            }
        },
        series: [
            {
                name: 'Movimientos',
                data: type_movements.map(tm => {
                    const state_m = stateMapping[tm.id] || [];
    
                    // Extraer todos los movimientos de este tipo en todos los proyectos
                    const movements = projects.flatMap(p => 
                        p.movements.filter(m => m.type_movement_id == tm.id)
                    );
    
                    // Sumar solo si el state_id es válido
                    const total = movements.reduce((acc, m) => {
                        return acc + (state_m.includes(m.state_id) ? parseFloat(m.value) : 0);
                    }, 0);
    
                    return total;
                })
            }
        ],
        plotOptions: {
            bar: {
                borderRadius: 10,
                barHeight: '60%',
                horizontal: true,
                distributed: true,
                startingShape: 'rounded',
                dataLabels: {
                    position: 'bottom'
                }
            }
        },
        dataLabels: {
            enabled: true,
            textAnchor: 'start',
            offsetY: 8,
            offsetX: 11,
            formatter: function (val) {
                if (val >= 1e9) return (val / 1e9).toFixed(1).replace(/\.0$/, '') + ' B';
                if (val >= 1e6) return (val / 1e6).toFixed(1).replace(/\.0$/, '') + ' M';
                if (val >= 1e3) return (val / 1e3).toFixed(1).replace(/\.0$/, '') + ' K';
                return val.toLocaleString(); // 👉 si es menor a 1000, se muestra con separador de miles normal
            },
            style: {
                fontWeight: 500,
                fontSize: '0.9375rem',
                fontFamily: 'Inter'
            }
        },
        tooltip: {
            x: {
                formatter: function (_val, { dataPointIndex }) {
                  // 👇 reemplaza el código (CI, VE...) por el nombre
                  return type_movements[dataPointIndex].name;
                }
            },
            y: {
                formatter: function (val) {
                    return formatPrice(val);
                },
                title: {
                    formatter: function () {
                      return "Valor: "; // 👈 aquí decides qué título quieres que salga en lugar de "Movimientos"
                    }
                }
            },
        },
        legend: {
            show: false
        },
        colors: type_movements.map(tm => {
            const color = colors.find(c => c.color == tm.color);
            return color ? color.hex : '#ccc';
        }),
        grid: {
            strokeDashArray: 8,
            borderColor,
            xaxis: { lines: { show: true } },
            yaxis: { lines: { show: false } },
            padding: {
                top: -18,
                left: 21,
                right: 33,
                bottom: 10
            }
        },
        xaxis: {
            categories: type_movements.map(tm => tm.code),
            labels: {
                formatter: function (val) {
                    const num = Number(val);
                    if (num >= 1e9) return (num / 1e9).toFixed(1).replace(/\.0$/, '') + 'B';
                    if (num >= 1e6) return (num / 1e6).toFixed(1).replace(/\.0$/, '') + 'M';
                    if (num >= 1e3) return (num / 1e3).toFixed(1).replace(/\.0$/, '') + 'K';
                    return num.toString();
                },
                style: {
                    fontSize: '13px',
                    colors: labelColor,
                    fontFamily: 'Inter'
                }
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        yaxis: {
            labels: {
                style: {
                    fontWeight: 500,
                    fontSize: '0.9375rem',
                    colors: headingColor,
                    fontFamily: 'Inter'
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
        }
    };
    if (typeof salesCountryChartEl !== undefined && salesCountryChartEl !== null) {
        const salesCountryChart = new ApexCharts(salesCountryChartEl, salesCountryChartConfig);
        salesCountryChart.render();
    }
}

function loadSwiper(){
    const swiperWithBgPagination = document.querySelector('#swiper-weekly-sales-with-bg');
    if (swiperWithBgPagination) {
        new Swiper(swiperWithBgPagination, {
            loop: true,
            autoplay: {
                delay: 10000,
                disableOnInteraction: true
            },
            pagination: {
                clickable: true,
                el: '.swiper-pagination'
            }
        });
    }
}

// Impression & Order Chart Function
function orderImpressionRadialBar(color, value) {
    const orderImpressionRadialBarOpt = {
      chart: {
        height: 90,
        width: 90,
        type: 'radialBar',
        sparkline: { enabled: true }
      },
      plotOptions: {
        radialBar: {
          hollow: {
            size: '52%'
          },
          dataLabels: {
            name: {
              show: false
            },
            value: {
              show: true,
              fontSize: '16px',
              fontWeight: 600,
              offsetY: 5,
              formatter: function (val) {
                return val + '%'; // 👉 aquí se agrega el símbolo %
              }
            }
          },
          track: {
            background: config.colors_label.secondary
          }
        }
      },
      states: {
        hover: { filter: { type: 'none' } },
        active: { filter: { type: 'none' } }
      },
      stroke: { lineCap: 'round' },
      colors: [color],
      grid: {
        padding: { bottom: 0 }
      },
      series: [value],
      labels: ['Progress'],
      responsive: [
        {
          breakpoint: 1400,
          options: { chart: { height: 100 } }
        },
        {
          breakpoint: 1380,
          options: { chart: { height: 96 } }
        },
        {
          breakpoint: 1354,
          options: { chart: { height: 93 } }
        },
        {
          breakpoint: 1336,
          options: { chart: { height: 88 } }
        },
        {
          breakpoint: 1286,
          options: { chart: { height: 84 } }
        },
        {
          breakpoint: 1258,
          options: { chart: { height: 80 } }
        },
        {
          breakpoint: 1200,
          options: { chart: { height: 98 } }
        }
      ]
    };
    return orderImpressionRadialBarOpt;
  }
  

function loadChart(){
    const chartProgressList = document.querySelectorAll('.chart-progress');
    if (chartProgressList) {
        chartProgressList.forEach(function (chartProgressEl) {
        const color = config.colors[chartProgressEl.dataset.color],
            series = chartProgressEl.dataset.series;
            const optionsBundle = orderImpressionRadialBar(color, series);
            const chart = new ApexCharts(chartProgressEl, optionsBundle);
            chart.render();
        });
    }
}
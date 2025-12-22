
// *******Overlay*******
// document.getElementById('toggleSidebar').addEventListener('click', function () {
//     var sidebar = document.getElementById('sidebar');
//     var overlay = document.getElementById('overlay');
//     sidebar.classList.toggle('active');
//     overlay.classList.toggle('active');
// });

// document.getElementById('overlay').addEventListener('click', function () {
//     var sidebar = document.getElementById('sidebar');
//     var overlay = document.getElementById('overlay');
//     sidebar.classList.remove('active');
//     overlay.classList.remove('active');
// });



//   const toggleBtn = document.getElementById('toggle-btn');
//   const sidebar = document.getElementById('sidebar');
//   const overlay = document.getElementById('overlay');
//   const closeBtn = document.getElementById('close-btn');

//   toggleBtn.addEventListener('click', () => {
//     sidebar.classList.add('show-sidebar');
//     overlay.classList.remove('d-none');
//   });

//   overlay.addEventListener('click', () => {
//     sidebar.classList.remove('show-sidebar');
//     overlay.classList.add('d-none');
//   });

//   closeBtn.addEventListener('click', () => {
//     sidebar.classList.remove('show-sidebar');
//     overlay.classList.add('d-none');
//   });



// document.addEventListener('DOMContentLoaded', function () {
//     const toggleBtn = document.getElementById('toggle-btn');
//     const sidebar = document.getElementById('sidebar');
//     const overlay = document.getElementById('overlay');

//     toggleBtn.addEventListener('click', function () {
//         sidebar.classList.toggle('open');
//         overlay.classList.toggle('open');
//         if (sidebar.classList.contains('open')) {
//             addCloseButton();
//         } else {
//             removeCloseButton();
//         }
//     });

//     overlay.addEventListener('click', function () {
//         sidebar.classList.remove('open');
//         overlay.classList.remove('open');
//         removeCloseButton();
//     });

//     function addCloseButton() {
//         if (!document.getElementById('close-btn')) {
//             const closeButton = document.createElement('button');
//             closeButton.id = 'close-btn';
//             closeButton.innerHTML = '<i class="fas fa-times"></i>';
//             closeButton.style.cssText = 'background: none; border: none; color: white; font-size: 1.5rem; cursor: pointer; position: absolute; top: 1rem; right: 1rem;';
//             closeButton.addEventListener('click', function () {
//                 sidebar.classList.remove('open');
//                 overlay.classList.remove('open');
//                 removeCloseButton();
//             });
//             sidebar.appendChild(closeButton);
//         }
//     }

//     function removeCloseButton() {
//         const closeButton = document.getElementById('close-btn');
//         if (closeButton) {
//             closeButton.remove();
//         }
//     }
// });


const linkColor = document.querySelectorAll('.sidebar-link')

function colorLink(){
if(linkColor){
linkColor.forEach(l=> l.classList.remove('active'))
this.classList.add('active')
}
}
linkColor.forEach(l=> l.addEventListener('click', colorLink))



// dataTables



// Graphs

    document.addEventListener('DOMContentLoaded', function () {
        var chartData = {
            chart: {
                type: 'pie'
            },
            title: {
                text: ''
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.percentage:.1f}%',
                        distance: -30, // Moves the labels inside the slices
                        style: {
                            color: 'white',
                            textOutline: 'none'
                        }
                    }
                }
            },
            series: [{
                data: [
                    { name: 'Verified', y: 3000, color: '#005555' },
                    { name: 'In Process', y: 5000, color: '#008080' },
                    { name: 'Not Verified', y: 2000, color: '#00aaaa' }
                ]
            }]
        };

        Highcharts.chart('chart-container-1', chartData);
        Highcharts.chart('chart-container-2', chartData);
        Highcharts.chart('chart-container-3', chartData);
        Highcharts.chart('chart-container-4', chartData);
        Highcharts.chart('chart-container-5', chartData);
        Highcharts.chart('chart-container-6', chartData);

    });

    const chartData = [
        { name: 'Physical Verification', y: 25, count: 1000 },
        { name: 'SPMS-9211', y: 22.5, count: 900 },
        { name: 'NADRA', y: 15, count: 600 },
        { name: 'PMD', y: 17.5, count: 700 },
        { name: 'BOP', y: 20, count: 800 }
    ];

    const chartColors = [
        '#3C91E6', // Physical Verification
        '#76C7C0', // SPMS-9211
        '#A1D9D6', // NADRA
        '#C7EBE5', // PMD
        '#E8F6F3'  // BOP
    ];

    function createChart(chartId) {
        Highcharts.chart(chartId, {
            chart: {
                type: 'pie'
            },
            title: {
                text: null
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}%',
                        distance: -30,
                        style: {
                            fontWeight: 'bold',
                            color: 'white',
                            textOutline: '1px contrast'
                        }
                    }
                }
            },
            series: [{
                name: 'Applications',
                colorByPoint: true,
                data: chartData,
                colors: chartColors
            }]
        });
    }

    createChart('chart1');
    createChart('chart2');

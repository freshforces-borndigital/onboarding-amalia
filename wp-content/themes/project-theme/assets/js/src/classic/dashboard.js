/* eslint-disable no-undef */
import $ from 'jquery';
import "../../../../node_modules/chart.js/dist/chart";
import "../../../../node_modules/chart.js-plugin-labels-dv/dist/chartjs-plugin-labels.min";

const element = document.getElementById("dashboard");
if (typeof element != "undefined" && element != null) {
  const CFG = window.THEMEOBJ;

  // const blue = "rgb(16 ,6, 159)";
  // const lightblue = "rgb(0, 163, 224)";
  // const teal = "rgb(0, 191, 179)";
  const travelMethods = CFG.travelMethods;
  const bgColors = travelMethods.map((v) => v.color);

  // let pusher = null;
  // let channel = null;

  let teamChart = null; // commuting chart
  let leftCampusChart = null; // not commuting chart
  let isNeedUpdate = false;

  // get IDs for the chart displayed at the right side of the screen
  const getRightChart = () => {
    const ids = travelMethods.map((v) => v.id);
    ids.pop(); // get rid of 'Not on campus' data (last element of array, not ideal solution since ID can be changed in future)
    return ids.map((id) => CFG.rightChart[id]);
  };

  // Get all icons from ASML data to place in chart (requires size)
  const getChartIcons = (size) => {
    const icons = travelMethods.map((v) => v.icon);
    let iconArr = [];

    icons.forEach((icon) => {
      iconArr.push({
        src: icon,
        width: size,
        height: size
      });
    });

    return iconArr;
  }

  // get IDs for the chart displayed at the left side of the screen
  const getLeftChart = () => {
    const ids = travelMethods.map((v) => v.id);
    ids.pop(); // get rid of 'Not on campus' data (last element of array, not ideal solution since ID can be changed in future)
    return ids.map((id) => CFG.leftChart[id] ?? 0);
  };

  // get specific item from data (requires a key and value)
  const getChartItem = (key, value) => {
    let item = travelMethods.find(data => data[key].toLowerCase() === value.toLowerCase());
    return item;
  };

  // create chart data for 1 item
  const singularChartData = (chart, item) => {
    return {
      datasets: [
        {
          label: "",
          data: [chart[item.id]],
          backgroundColor: bgColors.at(-1),
          hoverOffset: 2,
        },
      ],
    }
  };

  //  add back the "left side not in campus" chart to the team chart
  const leftCampusConfig = {
    type: "pie",
    data: singularChartData(CFG.leftChart, getChartItem("name", "Not on campus")),
    options: {
      maintainAspectRatio: true,
      plugins: {
        labels: [
          {
            // custom render function to add % symbol to value (because PERCENTAGE render displays incorrect float value out of 100 instead of value shown in data)
            render: function (args) {
              
              return Math.round(args.value) + "%";
            },
            fontSize: 14,
            fontStyle: 'bold',
            fontColor: '#000',
            fontFamily: 'neue-haas-grotesk-display',
            position: 'inside',
          },
        ],
        tooltip: {
          // use callback function to add % symbol to all tooltip values
          callbacks: { label: data => `${data.formattedValue}%` }
        }
      }
    }
  };

  // right chart singular data config for ChartJS
  const rightCampusConfig = {
    type: "pie",
    data: singularChartData(CFG.rightChart, getChartItem("name", "Not on campus")),
    options: {
      maintainAspectRatio: true,
      plugins: {
        labels: [
          {
            // custom render function to add % symbol to value (because PERCENTAGE render displays incorrect float value out of 100 instead of value shown in data)
            render: function (args) {
              return Math.round(args.value) + "%";
            },
            fontSize: 14,
            fontStyle: 'bold',
            fontColor: '#000',
            fontFamily: 'neue-haas-grotesk-display',
            position: 'inside',
          },
        ],
        tooltip: {
          // use callback function to add % symbol to all tooltip values
          callbacks: { label: data => `${data.formattedValue}%` }
        }
      }
    }
  };

  // left chart data + data config for ChartJS
  const teamChartData = {
    datasets: [
      {
        label: "",
        data: getLeftChart(),
        backgroundColor: bgColors,
        hoverOffset: 4,
      },
    ],
  };

  const teamChartConfig = {
    type: "pie",
    data: teamChartData,
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: 10,
      },
      plugins: {
        labels: [
          {
            render: function (args) {
              return args.percentage + "%";
            },
            fontSize: 14,
            fontStyle: 'bold',
            fontColor: '#000',
            fontFamily: 'neue-haas-grotesk-display',
            position: 'outside',
            textMargin: 5,
          },
          {
            render: 'image',
            images: getChartIcons(16)
          }
        ],
        tooltip: {
          callbacks: { label: data => `${data.formattedValue}%` }
        }
      }
    }
  };

  // right chart data + data config for ChartJS
  const asmlChartData = {
    datasets: [
      {
        label: "",
        data: getRightChart(),
        backgroundColor: bgColors,
        hoverOffset: 4,
      },
    ],
  };

  const asmlChartConfig = {
    type: "pie",
    data: asmlChartData,
    options: {
      maintainAspectRatio: false,
      plugins: {
        labels: [
          {
            render: function (args) {
              return args.value + "%";
            },
            fontSize: 14,
            fontStyle: 'bold',
            fontColor: '#000',
            fontFamily: 'neue-haas-grotesk-display',
            position: 'outside',
            textMargin: 5,
          },
          {
            render: 'image',
            images: getChartIcons(16)
          }
        ],
        tooltip: {
          // use callback function to add % symbol to all tooltip values
          callbacks: { label: data => `${data.formattedValue}%` }
        }
      }
    }
  };

  /* functions to create a new Chart instance */

  // eslint-disable-next-line no-unused-vars
  const asmlChart = new Chart(
      document.getElementById("asmlChart"),
      asmlChartConfig
  );

  // eslint-disable-next-line no-unused-vars
  const rightCampusChart = new Chart(
      document.getElementById("rightCampusChart"),
      rightCampusConfig
  );

  teamChart = new Chart(
      document.getElementById("teamChart"),
      teamChartConfig
  );
  leftCampusChart = new Chart(
    document.getElementById("leftCampusChart"),
    leftCampusConfig
  );

  const getUpdatedData = () => {
    const data = {
      action: "get_updated_team_chart",
      nonce: CFG.nonce,
      team_unique_link: $(".js-team").attr("data-unique-link"),
    };

    $.ajax({
      url: CFG.ajaxUrl,
      type: "post",
      data: data,
      dataType: "json",
      success: function (res) {

        if (!res.success) return;

        let newData = res.data;

        const is_same = JSON.stringify(newData) === JSON.stringify(CFG.leftChart);

        if (!is_same) {
          isNeedUpdate = true;
          CFG.leftChart = res.data;

          /* update data for all commuting methods */
          teamChartData.datasets[0].data.length = 0;
          teamChartData.datasets[0].data = getLeftChart();

          /* update data for not commuting */
          leftCampusConfig.data = singularChartData(CFG.leftChart, getChartItem("name", "Not on campus"));
        }
      }
    })
  }

  const renderTeamChart = () => {
    getUpdatedData();
    
    if (isNeedUpdate) {
      if (teamChart !== null) {
        teamChart.destroy();
        leftCampusChart.destroy();
      }

      /* re-render commuting charts */
      teamChart = new Chart(
          document.getElementById("teamChart"),
          teamChartConfig
      );

      /* re-render not commuting chart */
      leftCampusChart = new Chart(
          document.getElementById("leftCampusChart"),
          leftCampusConfig
      );

      isNeedUpdate = false;
    }
  }

  let countInterval = 0;
  let intrvlRenderChart;
  let renderLeftChart = () => {
    intrvlRenderChart = setInterval(function () {
      renderTeamChart();
      countInterval++;

      /** if there's no user interaction for 20 minutes (idle),
       * clear the interval,
       * so it won't affect load time performance
       ***/
      if (countInterval > 600) {
        clearInterval(intrvlRenderChart);
        intrvlRenderChart = null;
      }
    }, 2000);
  }

  renderLeftChart();

  /** restart the interval when there's mouse interaction
   *  and the interval is null ***/
  $(window).on("mouseover", function () {
    if (intrvlRenderChart === null) {
      countInterval = 0;
      renderLeftChart();
    }
  });

  /** restart the interval when there's keyboard interaction
   * and the interval is null ***/
  $(window).on("keypress", function () {
    if (intrvlRenderChart === null) {
      countInterval = 0;
      renderLeftChart();
    }
  });
}
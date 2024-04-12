document.addEventListener("DOMContentLoaded", function() {
    const menuToggle = document.querySelector(".menu-toggle");
    const menu = document.querySelector(".menu");
  
        // Get the canvas element
        var ctx = document.getElementById('occupancy-chart').getContext('2d');
    
        // Define the data for the chart (example data)
        var data = {
            labels: ['Room 1', 'Room 2', 'Room 3', 'Room 4'],
            datasets: [{
                label: 'Occupancy',
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // blue color with transparency
                borderColor: 'rgba(255, 99, 132, 1)', 
                borderWidth: 1,
                data: [3, 1, 2, 4] // Example occupancy data
            }]
        };
    
        // Create the chart
        var myChart = new Chart(ctx, {
            type: 'bar', // Bar chart type
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true // Start y-axis at 0
                    }
                }
            }
        });
    


    menuToggle.addEventListener("click", function() {
      menu.classList.toggle("active");
    });
        
  
    // Close the menu when a menu item is clicked
    const menuItems = document.querySelectorAll(".menu a");
    menuItems.forEach(function(item) {
      item.addEventListener("click", function() {
        menu.classList.remove("active");
      });
    });

  

  });
  
  
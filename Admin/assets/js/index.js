const usersCount = document.querySelector(".users-count"),
  activitiesCount = document.querySelector(".activities-count"),
  usersListBody = document.querySelector(".users-list-body");

var male = 0,
  female = 0,
  others = 0;

fetch("/webdevproject/Auth/auth.php?fetch=users")
  .then((res) => res.json())
  .then((data) => {
    usersListBody.querySelector("tbody").innerHTML = "";
    usersCount.textContent = data.length - 1;
    data.map((user) => {
      console.log(user);
      if (user.gender.toLowerCase() === "male") {
        male += 1;
      }
      if (user.gender.toLowerCase() === "female") {
        female += 1;
      }
      if (user.gender.toLowerCase() === "others") {
        others += 1;
      }
      let template = `
        <tr class="p-3">
            <th scope="row">${user.id}</th>
            <td>${user.firstname} ${user.lastname}</td>
            <td>${user.gender}</td>
            <td>${user.address}</td>
            <td>${user.emailAddress}</td>
            <td>
                <span class="badge bg-${
                  user.status == "active" ? "success" : "danger"
                } p-2" style="text-transform: uppercase;">${user.status}</span>
            </td>
            <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" data-user-id="${user.id}" data-user-firstname="${user.firstname}" data-user-lastname="${user.lastname}" data-user-gender="${user.gender}" data-user-address="${user.address}" data-user-email="${user.emailAddress}">Edit</button></td>
        </tr>
      `;
      if (user.role !== "admin") {
        usersListBody
          .querySelector("tbody")
          .insertAdjacentHTML("beforeend", template);
      }
    });

    echarts.init(document.querySelector("#trafficChart")).setOption({
      tooltip: {
        trigger: "item",
      },
      legend: {
        top: "5%",
        left: "center",
      },
      series: [
        {
          name: "User Gender",
          type: "pie",
          radius: ["40%", "70%"],
          avoidLabelOverlap: false,
          label: {
            show: false,
            position: "center",
          },
          emphasis: {
            label: {
              show: true,
              fontSize: "18",
              fontWeight: "bold",
            },
          },
          labelLine: {
            show: false,
          },
          data: [
            {
              value: male,
              name: "Male",
            },
            {
              value: others,
              name: "Others",
            },
            {
              value: female,
              name: "Female",
            },
          ],
        },
      ],
    });
  });

fetch("/webdevproject/Auth/auth.php?fetch=all")
  .then((res) => res.json())
  .then((data) => {
    activitiesCount.textContent = data.length;
  });

// Activity Chart
function getMonthFromDateStr(dateStr) {
  const date = new Date(dateStr);
  if (isNaN(date)) {
    return "Invalid Date";
  }
  const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];
  const monthName = months[date.getMonth()];
  return monthName;
}

document.addEventListener("DOMContentLoaded", () => {
  function randomColor() {
    return `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(
      Math.random() * 256
    )}, ${Math.floor(Math.random() * 256)}, 0.2)`;
  }

  const randomColors = Array.from(
    {
      length: 12,
    },
    randomColor
  );

  fetch("/webdevproject/Auth/auth.php?fetch=all")
    .then((res) => res.json())
    .then((data) => {
      const monthCounts = {
        January: 0,
        February: 0,
        March: 0,
        April: 0,
        May: 0,
        June: 0,
        July: 0,
        August: 0,
        September: 0,
        October: 0,
        November: 0,
        December: 0,
      };
      data.forEach((activity) => {
        const month = getMonthFromDateStr(activity.activityDate);
        if (month in monthCounts) {
          monthCounts[month]++;
        }
      });

      // Extract the numbers (activity counts) from the monthCounts object
      const activityCounts = Object.values(monthCounts);

      new Chart(document.querySelector("#barChart"), {
        type: "bar",
        data: {
          labels: [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
          ],
          datasets: [
            {
              label: "Activity Chart",
              data: activityCounts, // Use the extracted activity counts
              backgroundColor: randomColors,
              borderColor: randomColors.map((color) =>
                color.replace("0.2", "1")
              ), // Solid borders
              borderWidth: 1,
            },
          ],
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
            },
          },
        },
      });
    });
});

// ! Announcements
const addAnnouncementForm = document.querySelector(".add-announcement-form"),
  closeAnnouncementForm = document.querySelector(
    ".close-add-announcement-form"
  ),
  addAnnouncementBtn = document.querySelector(".add-announcement-btn");

const handleAnnouncement = () => {
  if (addAnnouncementForm.classList.contains("show")) {
    addAnnouncementForm.classList.remove("show");
  } else addAnnouncementForm.classList.add("show");
};

closeAnnouncementForm.addEventListener("click", handleAnnouncement);
addAnnouncementBtn.addEventListener("click", handleAnnouncement);

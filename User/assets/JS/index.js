// ! Tool Functions
function convertTo12HourFormat(time) {
  let [hours, minutes] = time.split(":");
  let period = "AM";
  let hour = parseInt(hours);
  if (hour >= 12) {
    period = "PM";
    if (hour > 12) {
      hours = hour - 12;
    }
  }
  const formattedTime = `${hours}:${minutes} ${period}`;

  return formattedTime;
}

function isDateToday(dateString) {
  const currentDate = new Date();
  const providedDate = new Date(dateString + "T00:00:00.000"); // Set the time to midnight
  currentDate.setHours(0, 0, 0, 0); // Set the time of the current date to midnight
  return providedDate.getTime() === currentDate.getTime();
}

function checkDate(dateString) {
  const inputDate = new Date(dateString);
  const currentDate = new Date();
  if (inputDate < currentDate) {
    return "past";
  } else if (inputDate > currentDate) {
    return "future";
  } else {
    return "present";
  }
}

const addActivityBtn = document.querySelector(".add-activity-btn"),
  closeAddActivityForm = document.querySelector(".close-add-activity-form"),
  addActivityForm = document.querySelector(".add-activity-form"),
  addActivityInputs = addActivityForm.querySelectorAll("input"),
  addActivityDesc = addActivityForm.querySelector("textarea");

addActivityBtn.addEventListener("click", () => {
  if (addActivityForm.classList.contains("show")) {
    addActivityForm.querySelector("form").action =
      "/WebdevProject/Auth/auth.php?activity=add";
    addActivityForm.querySelector("#activity-submit").textContent =
      "Add Activity";
    addActivityForm.querySelector("h3").textContent = "Add An Activity";
    addActivityDesc.value = "";
    addActivityInputs.forEach((input, index) => {
      if (index != 0) {
        input.value = "";
      }
    });
    addActivityForm.classList.remove("show");
  } else {
    addActivityForm.classList.add("show");
  }
});

closeAddActivityForm.addEventListener("click", () => {
  addActivityForm.classList.remove("show");
  let inputs = addActivityForm.querySelectorAll("input");
  addActivityForm.querySelector("textarea").value = "";
  inputs.forEach((input) => {
    if (input.type != "hidden") {
      input.value = "";
    }
  });
});

// ! Templates
const pageTitle = (title, func) => {
  return `
  <div class="pagetitle">
  <h1>${title}</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item active">${title}</li>
    </ol>
  </nav>
</div>
`;
};

const activitiesBtn = document.querySelector(".activities-btn"),
  mainDiv = document.querySelector("main.main"),
  activityDiv = document.createElement("div"),
  altActivitiesBtn = document.querySelector(".view-activities-alt-btn");

activityDiv.className = "row";

altActivitiesBtn.addEventListener("click", () => {
  activitiesBtn.click();
});

activitiesBtn.addEventListener("click", () => {
  mainDiv.innerHTML = "";
  activityDiv.innerHTML = "";
  mainDiv.insertAdjacentHTML("beforeend", pageTitle("Activities"));
  fetch("/webdevproject/Auth/auth.php?fetch=activities")
    .then((res) => res.json())
    .then((data) => {
      data.map((activity) => {
        let activityTemplate = `
        <div class="col-md-4 col-sm-6 content-card">
        <div class="card-big-shadow">
            <div class="card card-just-text" data-background="color" data-color="${
              activity.status === "done" ? "green" : "yellow"
            }" data-radius="none">
                  <div class="content">
                    ${
                      activity.activityImg
                        ? `<img src="../Auth/${activity.activityImg}" width="80" height="80" style="margin: 10px 0; border-radius: 5px;">`
                        : ""
                    }
                    <h6 class="category">${
                      activity.activityDate
                    } at ${convertTo12HourFormat(activity.activityTime)}</h6>
                    <h4 class="title">${activity.activityName}</h4>
                    <p class="description">${activity.activityDesc}</p>
                    <p class="description" style="font-size: 70%; color: #0006;">${
                      activity.activityLocation
                    }</p>
                </div>
            </div> <!-- end card -->
        </div>
    </div>
        `;
        activityDiv.insertAdjacentHTML("beforeend", activityTemplate);
      });
      mainDiv.insertAdjacentElement("beforeend", activityDiv);
    });
});

const manageActivitiesBtn = document.querySelector(".manage-activities-btn"),
  altManageActivitiesBtn = document.querySelector(".manage-activity-alt-btn"),
  altDeleteActivitiesBtn = document.querySelector(".delete-activity-alt-btn");

altManageActivitiesBtn.addEventListener("click", () => {
  manageActivitiesBtn.click();
});

altDeleteActivitiesBtn.addEventListener("click", () => {
  manageActivitiesBtn.click();
});

manageActivitiesBtn.addEventListener("click", () => {
  mainDiv.innerHTML = "";
  activityDiv.innerHTML = ``;
  mainDiv.insertAdjacentHTML("beforeend", pageTitle("Manage Activities"));
  fetch("/webdevproject/Auth/auth.php?fetch=activities")
    .then((res) => res.json())
    .then((data) => {
      let activityTemplate = `
      <div class="table-responsive">
      <h6>Click on the status to update it.</h6>
      <table id="example" style="width:100%" class="text-center table table-striped table-bordered datatable">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Date</th>
            <th scope="col">Time</th>
            <th scope="col">Location</th>
            <th scope="col">OOTD</th>
            <th scope="col">Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          ${data
            .map((activity) => {
              return `
          <tr style="vertical-align: middle;">
            <td class="activity-id" style="display: none;">${
              activity.activityId
            }</td>
            <td>${activity.activityName}</td>
            <td>${activity.activityDesc}</td>
            <td>${activity.activityDate}</td>
            <td>${activity.activityTime}</td>
            <td>${activity.activityLocation}</td>
            <td>${
              activity.activityImg
                ? `<img src="../Auth/${activity.activityImg}" style="width: 60px; height: 60px;">`
                : "No Image Found."
            }</td>
            <td><a href="/WebdevProject/Auth/auth.php?activity=toggle&id=${
              activity.activityId
            }&status=${activity.status}" class="badge bg-${
                activity.status === "done" ? "success" : "warning"
              }" style="color: #fff; text-transform: uppercase;">${
                activity.status
              }</a></td>
            <td style="display:flex;flex-direction: column; gap: 5px;"><button class="edit-activity-btn btn btn-primary">Edit</button><a href="/WebdevProject/Auth/auth.php?activity=delete&id=${
              activity.activityId
            }" class="btn btn-danger" onclick="return confirm('Confirm to delete this activity?')">Delete</a>
            </td>
          </tr>
          `;
            })
            .join("")}
        </tbody>
      </table>
    </div>
      `;
      activityDiv.insertAdjacentHTML("beforeend", activityTemplate);
      mainDiv.insertAdjacentElement("beforeend", activityDiv);

      const editActivityBtn = document.querySelectorAll(".edit-activity-btn");

      editActivityBtn.forEach((btn) => {
        btn.addEventListener("click", () => {
          var currentActivity = btn.closest("tr"),
            currentActivityTd = currentActivity.querySelectorAll("td");
          addActivityForm.querySelector(
            "form"
          ).action = `/WebdevProject/Auth/auth.php?activity=edit&id=${currentActivityTd[0].textContent}`;
          addActivityForm.querySelector("#activity-submit").textContent =
            "Edit Activity";
          addActivityForm.querySelector("h3").textContent =
            "Edit This Activity";
          addActivityBtn.click();
          addActivityInputs.forEach((input, index) => {
            if (index == 1) {
              input.value = currentActivityTd[3].textContent;
            }
            if (index == 2) {
              input.value = currentActivityTd[4].textContent;
            }
            if (index == 3) {
              input.value = currentActivityTd[1].textContent;
            }
            if (index == 4) {
              addActivityDesc.value = currentActivityTd[2].textContent;
            }
            if (index == 5) {
              input.value = currentActivityTd[5].textContent;
            }
          });
        });
      });
    });
});

const latestSection = document.querySelector(".latest-section"),
  activityCount = document.querySelector(".activity-ahead"),
  activityToday = document.querySelector(".activity-today");

let foundMatch = false;
const updateDashboardLatest = () => {
  fetch("/webdevproject/Auth/auth.php?fetch=activities")
    .then((res) => res.json())
    .then((data) => {
      data.forEach((activity) => {
        if (!foundMatch) {
          var template = `
            <div class="col-md-4 col-sm-6 content-card w-100" style="height: auto;">
                <div class="card-big-shadow">
                    <div class="card card-just-text" data-background="color" data-color="${
                      activity.status === "done" ? "green" : "yellow"
                    }" data-radius="none">
                        <div class="content">
                            ${
                              activity.activityImg
                                ? `<img src="../Auth/${activity.activityImg}" width="80" height="80" style="margin: 10px 0; border-radius: 5px;">`
                                : ""
                            }
                            <h6 class="category">${
                              activity.activityDate
                            } at ${convertTo12HourFormat(
            activity.activityTime
          )}</h6>
                            <h4 class="title">${activity.activityName}</h4>
                            <p class="description">${activity.activityDesc}</p>
                            <p class="description" style="font-size: 70%; color: #0006;">${
                              activity.activityLocation
                            }</p>
                        </div>
                    </div> <!-- end card -->
                </div>
            </div>
            `;
          if (
            checkDate(activity.activityDate) == "future" &&
            activity.status != "done"
          ) {
            latestSection.innerHTML = template;
            foundMatch = true;
          }
        }
      });

      activityCount.innerHTML = `You have ${data.length} Activities Ahead`;
      var count = 0;
      data.map((activity) => {
        if (isDateToday(activity.activityDate) && activity.status != "done") {
          count += 1;
        }
        activityToday.innerHTML = `You have ${count} Activities Today`;
      });
    });
};

updateDashboardLatest();

const announcementBtn = document.querySelector(".announcements-card"),
  announcementContainer = document.querySelector(".announcement-container"),
  announcementDiv = document.querySelector(".announcement-div");

announcementBtn.addEventListener("click", () => {
  if (announcementContainer.classList.contains("show")) {
    announcementContainer.classList.remove("show");
  } else announcementContainer.classList.add("show");
});

fetch("/webdevproject/Auth/auth.php?fetch=announcements")
  .then((res) => res.json())
  .then((data) => {
    document.querySelector(
      ".announcement-count"
    ).textContent = `There are ${data.length} announcement/s`;
    announcementDiv.innerHTML = "";
    data.map((announcement) => {
      let template = `
      <div class="alert alert-info  alert-dismissible fade show" role="alert">
          <h4 class="alert-heading">${announcement.title}</h4>
          <p>${announcement.content}</p>
          <hr>
          <p class="mb-0">${announcement.createdAt}</p>
      </div>
      `;
      announcementDiv.insertAdjacentHTML("beforeend", template);
    });
  });

const dialog = document.querySelector("#requestPo");
const closeHallModalButton = document.querySelector("#close-button");
var roomItems = document.querySelectorAll("#roomItem");
var hallInfoModal = document.querySelector("#hall-modal");
const showButton = document.querySelector("#button");
const closeButton = document.querySelector("#closeBtn");

function openHallInfoModalContainer() {
    hallInfoModal.style.display = 'block';
}

function closeHallInfoModalContainer() {
    hallInfoModal.style.display = 'none';

    // remove modal content
    var modalContent = document.querySelector("#hall-modal-content");
    modalContent.remove();

    // add empty modal content div
    const modalContentDiv = document.createElement("div");
    modalContentDiv.classList.add("modal-content");
    modalContentDiv.id = "hall-modal-content";
    hallInfoModal.appendChild(modalContentDiv);
}

function getHallInfo(hall_id) {
    var modalContent = document.querySelector("#hall-modal-content");

    fetch('../action/getHall.php?id=' + hall_id)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {

            const hall_info = data.hall_info[0];
            const hall_rooms_and_members = data.hall_rooms_and_members;
            console.log(hall_rooms_and_members);
            
            // Create a div element with class "block_item"
            const blockItem1 = document.createElement("div");
            blockItem1.classList.add("block_item");

            // Create an anchor element with class "block_title" and set its text content
            const blockTitle = document.createElement("a");
            blockTitle.classList.add("block_title");
            blockTitle.textContent = "Hall Name:";
            // Append the blockTitle to the blockItem
            blockItem1.appendChild(blockTitle);

            // Create another anchor element with class "block_value" and set its text content
            const blockValue = document.createElement("a");
            blockValue.classList.add("block_value");
            blockValue.textContent = hall_info.hall_name;
            // Append the blockValue to the blockItem
            blockItem1.appendChild(blockValue);

            // Create a div element with class "block_item"
            const blockItem2 = document.createElement("div");
            blockItem2.classList.add("block_item");

            // Create and append elements for Capacity
            const blockTitleCapacity = document.createElement("a");
            blockTitleCapacity.classList.add("block_title");
            blockTitleCapacity.textContent = "Capacity:";
            blockItem2.appendChild(blockTitleCapacity);

            const blockValueCapacity = document.createElement("a");
            blockValueCapacity.classList.add("block_value");
            blockValueCapacity.textContent = hall_info.capacity;
            blockItem2.appendChild(blockValueCapacity);

            // Create a div element with class "block_item"
            const blockItem3 = document.createElement("div");
            blockItem3.classList.add("block_item");

            // Create and append elements for Location
            const blockTitleLocation = document.createElement("a");
            blockTitleLocation.classList.add("block_title");
            blockTitleLocation.textContent = "Location:";
            blockItem3.appendChild(blockTitleLocation);

            const blockValueLocation = document.createElement("a");
            blockValueLocation.classList.add("block_value");
            blockValueLocation.textContent = hall_info.location;
            blockItem3.appendChild(blockValueLocation);

            // loop through hall_rooms_and_members and display rooms and halls
            // Create a container for all rooms
            const roomsContainer = document.createElement("div");
            roomsContainer.classList.add("rooms");

            if (hall_rooms_and_members.length === 0) {
                const noRoomsMessage = document.createElement("div");
                noRoomsMessage.textContent = "No rooms in this hall";
                roomsContainer.appendChild(noRoomsMessage);
            } else {
                // Loop through each room
                hall_rooms_and_members.forEach(room => {
                    // Create a div for each room
                    const roomDiv = document.createElement("div");
                    roomDiv.classList.add("room");
            
                    // Create room name element
                    const roomName = document.createElement("div");
                    roomName.classList.add("room_name");
                    roomName.textContent = "Room " + room.room_name;
                    const roomCapacity = document.createElement("div");
                    roomCapacity.classList.add("room_name")
                    roomCapacity.textContent = "(Cap: " + room.capacity + ")"
                    roomDiv.appendChild(roomName);
                    roomDiv.appendChild(roomCapacity);
            
                    // Check if there are members for this room
                    if (room.members && room.members.length > 0) {
                        // Create members container
                        const membersContainer = document.createElement("div");
                        membersContainer.classList.add("members");
            
                        // Create members title
                        const membersTitle = document.createElement("a");
                        membersTitle.classList.add("members_title");
                        membersTitle.textContent = "Members:";
                        membersContainer.appendChild(membersTitle);
            
                        // Create member list
                        const memberList = document.createElement("ol");
                        memberList.classList.add("member_list");
            
                        // Loop through each member and create list items
                        room.members.forEach(member => {
                            const memberListItem = document.createElement("li");
                            memberListItem.classList.add("memberName");
                            memberListItem.textContent = member.username;
                            memberList.appendChild(memberListItem);
                        });
            
                        membersContainer.appendChild(memberList);
                        roomDiv.appendChild(membersContainer);
                    } else {
                        // Create members container
                        const membersContainer = document.createElement("div");
                        membersContainer.classList.add("members");
                        
                        // Display message if no members found for the room
                        const noMembers = document.createElement("div");
                        noMembers.textContent = "No members in this room";
                        membersContainer.appendChild(noMembers);
                        roomDiv.appendChild(membersContainer);
                    }
            
                    // Create joined status element
                    const joinedStatus = document.createElement("div");
                    joinedStatus.classList.add("joined_status");
            
                    // Create join button
                    const joinButton = document.createElement("a");
                    joinButton.href = "../action/bookRoom.php?room_id=" + room.room_id
                    joinButton.classList.add("join-button");
            
                    // Add image to join button
                    const descriptionIcon = document.createElement("img");
                    descriptionIcon.classList.add("description-icon");
                    descriptionIcon.src = "../assets/plus1.png";
                    descriptionIcon.alt = "Description Icon";
                    descriptionIcon.style.width = "15%";
                    joinButton.appendChild(descriptionIcon);
            
                    joinedStatus.appendChild(joinButton);
                    roomDiv.appendChild(joinedStatus);
            
                    // Append room div to rooms container
                    roomsContainer.appendChild(roomDiv);
                });
            }

            // Create a div element for close button
            const buttonDiv = document.createElement("div");
            // Set style attribute
            buttonDiv.style.display = "flex";
            buttonDiv.style.justifyContent = "center";
            buttonDiv.style.paddingTop = "1em";

            // Create a button element
            const button = document.createElement("button");
            // Set attributes for the button
            button.type = "button";
            button.id = "close-button";
            button.className = "close-button";
            // Add click event listener to the button
            button.onclick = closeHallInfoModalContainer;

            // Create a span element
            const span = document.createElement("span");
            // Set text content for the span
            span.textContent = "Cancel";

            // Append the span to the button
            button.appendChild(span);
            buttonDiv.appendChild(button);

            // Append the blockItem and button to the container
            modalContent.appendChild(blockItem1);
            modalContent.appendChild(blockItem2);
            modalContent.appendChild(blockItem3);
            modalContent.appendChild(roomsContainer);
            modalContent.appendChild(buttonDiv);

            // open modal container
            openHallInfoModalContainer();
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

roomItems.forEach(roomItem => {
    roomItem.addEventListener('click', () => {
        // retrieve hall_id from tag
        var hall_id = roomItem.getAttribute("hall_id");
        
        // make AJAX request to fetch hall info
        getHallInfo(hall_id);
    });
});

showButton.addEventListener("click", () =>{
    dialog.showModal();
});

closeButton.addEventListener("click", () =>{
    dialog.close();
});
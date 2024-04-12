document.addEventListener("DOMContentLoaded", function() {
    const joinRoomBtn = document.getElementById('join-room');
    const membersCount = document.querySelector('.members');
    const leaveRoomBtn = document.getElementById('leave-room');

    joinRoomBtn.addEventListener('click', function() {
        // Extracting the current number of members
        const currentMembers = parseInt(membersCount.textContent.split('/')[0]);

        // Extracting the maximum number of members
        const maxMembers = parseInt(membersCount.textContent.split('/')[1].split(' ')[0]);

        // Increment the number of members if it's less than the maximum
        if (currentMembers < maxMembers) {
            membersCount.textContent = (currentMembers + 1) + '/' + maxMembers + ' students';
        } else {
            alert('This room is already full!');
        }
    });

    leaveRoomBtn.addEventListener('click', function() {
        // Extracting the current number of members
        const currentMembers = parseInt(membersCount.textContent.split('/')[0]);

        // Extracting the maximum number of members
        const maxMembers = parseInt(membersCount.textContent.split('/')[1].split(' ')[0]);

        // Decrease the number of members if button is clicked
        if (currentMembers < maxMembers) {
            membersCount.textContent = (currentMembers - 1) + '/' + maxMembers + ' students';
        } else {
            alert('This room is empty!');
        }

    });
});

<div class="row justify-content-center mt-5">
  <div class="col-12">
    <div class="card shadow  text-white bg-dark">
      <div class="card-header">Coding Challenge - Network connections</div>
      <div class="card-body">
        <div class="btn-group w-100 mb-3" role="group" aria-label="Basic radio toggle button group">
          <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
          <label class="btn btn-outline-primary" for="btnradio1" id="get_suggestions_btn">Suggestions (<span id="suggestions_count"></span>)</label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
          <label class="btn btn-outline-primary" for="btnradio2" id="get_sent_requests_btn">Sent Requests (<span id="sent_requests_count"></span>)</label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
          <label class="btn btn-outline-primary" for="btnradio3" id="get_received_requests_btn">Received
            Requests(<span id="received_requests_count"></span>)</label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
          <label class="btn btn-outline-primary" for="btnradio4" id="get_connections_btn">Connections (<span id="connections_count"></span>)</label>
        </div>
        <hr>
        <div id="content" class="">
        </div>
        <div id="common_connections_content"></div>

        <div class="d-flex justify-content-center mt-2 py-3 {{-- d-none --}}" id="load_more_btn_parent">
          <button class="btn btn-primary" onclick="" id="load_more_btn">Load more</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$(document).ready(function() {
  let currentPage = 1; 
$(document).ready(function() {
  $('#get_suggestions_btn').click(function() {
    currentPage = 1; 
    getSuggestions(); 
  });
  $('#load_more_btn').click(function() {
    currentPage++; 
    getSuggestions();
  });
  getSuggestions();
});

function getSuggestions() {
  $.ajax({
    url: '/api/suggestions',
    method: 'GET',
    data: {
      page: currentPage, 
    },
    success: function(response) {
      displaySuggestions(response.data);
      $('#load_more_btn').toggle(response.current_page < response.last_page);

    },
    error: function(xhr, status, error) {
      console.log(error);
    }
  });
}

function displaySuggestions(suggestions) {
  var content = '';
  var count = suggestions.length;

  $.each(suggestions, function(index, suggestion) {
    content += `
      <div class="my-2 shadow text-white bg-dark p-1" id="suggestion_${suggestion.id}">
        <div class="d-flex justify-content-between">
          <table class="ms-1">
            <td class="align-middle">${suggestion.name}</td>
            <td class="align-middle"> - </td>
            <td class="align-middle">${suggestion.email}</td>
            <td class="align-middle"> 
          </table>
          <div>
            <button class="btn btn-primary me-1 connect-btn" data-user-id="${suggestion.id}">Connect</button>
          </div>
        </div>
      </div>
    `;
  });

  $('#suggestions_count').text(count);

  $('#content').html(content);
  $('#common_connections_content').html('')
}

  $(document).on('click', '.connect-btn', function() {
    var userId = $(this).data('user-id');
    console.log(userId);
    $.ajax({
      url: `/api/users/${userId}/connect`,
      method: 'POST',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: function(response) {
       
        $(`#suggestion_${userId}`).remove();
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });
  });
});



$(document).ready(function() {
  $('#get_sent_requests_btn').click(function() {
    $.ajax({
      url: '/api/users/sent-requests',
      method: 'GET',
      success: function(response) {
        displaySentRequests(response);
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });
  });
  

  function displaySentRequests(sentRequests) {
    var content = '';
    var count = sentRequests.length; 
    $.each(sentRequests, function(index, sentRequest) {
      content += `
        <div class="my-2 shadow text-white bg-dark p-1" id="sent_requests_${sentRequest.receiver_id}">
          <div class="d-flex justify-content-between">
            <table class="ms-1">
              <td class="align-middle">${sentRequest.receiver.name}</td>
              <td class="align-middle"> - </td>
              <td class="align-middle">${sentRequest.receiver.email}</td>
              <td class="align-middle"> 
            </table>
            <div>
              <button class="btn btn-danger me-1 with-draw-btn" data-user-id="${sentRequest.receiver_id}">WithDraw Request</button>
            </div>
          </div>
        </div>
      `;
    });
    $('#sent_requests_count').text(count);
    $('#content').html(content);
    $('#common_connections_content').html('')

  }

  $(document).on('click', '.with-draw-btn', function() {
    var userId = $(this).data('user-id');
    console.log(userId);
    $.ajax({
      url: `/api/users/${userId}/withdraw-request`,
      method: 'POST',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: function(response) {
       
        $(`#sent_requests_${userId}`).remove();
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });
  });
});




$(document).ready(function() {
  $('#get_received_requests_btn').click(function() {
    $.ajax({
      url: '/api/users/received-requests',
      method: 'GET',
      success: function(response) {
        displayReceivedRequests(response);
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });
  });

  function displayReceivedRequests(receivedRequests) {
    var content = '';
    var count = receivedRequests.length; 
    $.each(receivedRequests, function(index, receivedRequest) {
      content += `
        <div class="my-2 shadow text-white bg-dark p-1" id="received_requests_${receivedRequest.user_id}">
          <div class="d-flex justify-content-between">
            <table class="ms-1">
              <td class="align-middle">${receivedRequest.sender.name}</td>
              <td class="align-middle"> - </td>
              <td class="align-middle">${receivedRequest.sender.email}</td>
              <td class="align-middle"> 
            </table>
            <div>
              <button class="btn btn-primary me-1 accept-btn" data-user-id="${receivedRequest.user_id}">Accept</button>
            </div>
          </div>
        </div>
      `;
    });
    $('#received_requests_count').text(count);
    $('#content').html(content);
    $('#common_connections_content').html('')

  }

  $(document).on('click', '.accept-btn', function() {
    var userId = $(this).data('user-id');
    console.log(userId);
    $.ajax({
      url: `/api/users/${userId}/accept-request`,
      method: 'POST',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: function(response) {
       
        $(`#received_requests_${userId}`).remove();
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });
  });
});





$(document).ready(function() {
  $('#get_connections_btn').click(function() {
    $.ajax({
      url: '/api/users/connections',
      method: 'GET',
      success: function(response) {
        displayConnections(response);
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });
  });

  function displayConnections(connections) {
    var content = '';
    var count = connections.length; 

    $.each(connections, function(index, connection) {
      content += `
        <div class="my-2 shadow text-white bg-dark p-1" id="connections_${connection.pivot.connection_id}">
          <div class="d-flex justify-content-between">
            <table class="ms-1">
              <td class="align-middle">${connection.name}</td>
              <td class="align-middle"> - </td>
              <td class="align-middle">${connection.email}</td>
              <td class="align-middle"> 
            </table>
            <div>
              <button class="btn btn-primary me-1 common-btn" data-user-id="${connection.pivot.connection_id}">Common Connection</button>
              <button class="btn btn-danger me-1 remove-btn" data-user-id="${connection.pivot.connection_id}">Remove Connection</button>
            </div>
          </div>
        </div>
      `;
    });
    $('#connections_count').text(count);
    $('#content').html(content);
  }

  $(document).on('click', '.remove-btn', function() {
    var userId = $(this).data('user-id');
    console.log(userId);
    $.ajax({
      url: `/api/users/${userId}/remove-connection`,
      method: 'POST',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: function(response) {
       
        $(`#connections_${userId}`).remove();
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });
  });
  
    $(document).on('click', '.common-btn', function() {
        var userId = $(this).data('user-id');
        $.ajax({
        url: `/api/users/${userId}/common-connections`,
        method: 'GET',
        success: function(response) {
          displayCommonConnections(response);
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
      });

      function displayCommonConnections(commonConnections) {
    var content = '';
console.log(commonConnections);
    $.each(commonConnections, function(index, commonConnection) {
      content += `
        <div class="my-2 shadow text-white bg-dark p-1" id="connections_${commonConnection}">
          <div class="d-flex justify-content-between">
            <table class="ms-1">
              <td class="align-middle">${commonConnection.name}</td>
              <td class="align-middle"> - </td>
              <td class="align-middle">${commonConnection.email}</td>
              <td class="align-middle"> 
            </table>
          </div>
        </div>
      `;
    });
    $('#common_connections_content').html(content);
  }
  });
});

</script>
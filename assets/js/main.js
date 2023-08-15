jQuery(document).ready(function($) {
  $(document).ready(function() {
    var header = document.getElementById('thrive-header'); 
    window.addEventListener('scroll', function() {
      var currentPosition = window.pageYOffset || document.documentElement.scrollTop;
      
      if (currentPosition > 0) {
        header.classList.add('scroll-up');
      } else {
        header.classList.remove('scroll-up');
      }
    });
//     window.addEventListener("mousemove", function(event) {
//       var mouseY = event.clientY;
  
//       if (mouseY <= 50) {
//         var currentPosition = window.pageYOffset;
//         if(currentPosition > 50)
//           header.classList.add('scroll-up');
// 		  header.style.setProperty('top', '32px', 'important');
//       }
//     });
    // Get the modal
    var modal = document.getElementById('searchModal');
    
    // Get the button that opens the modal
    var btn = document.getElementById("yourSearchButtonId");
    
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    
    // When the user clicks on the button, open the modal
    btn.onclick = function() {
    console.log(1);
      modal.style.display = "block";
	  $('footer > div').css('z-index', 30);
    }
    
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
	  $('footer > div').css('z-index', 14);
    }
    
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
		$('footer > div').css('z-index', 14);
      }
    }
    $('#search-form').on('submit', function(e) {
        e.preventDefault();
        let searchString = $('#s').val();
        console.log(searchString);
        fetchResults(searchString);
    });
  
    function fetchResults(searchString) {
		var results = '';
        $.ajax({
            url: '/wp-json/wp/v2/posts?search=' + searchString,
            type: 'GET',
            success: function(data) {
                data.forEach(post => {
//                     results += `<h3>${post.title.rendered}</h3><p>${post.excerpt.rendered}</p><a href="${post.link}">Read More</a>`;
                     results += `<a href="${post.link}" class="search-result__item">${post.excerpt.rendered}</a>`;
                });
                $('#search-results').html(results);
            },
            error: function(err) {
                $('#search-results').html('<p>Error retrieving search results. Please try again.</p>');
            }
        });
    }
  
  
    // footer background color
    const currentUrl = window.location.href;
	  console.log(currentUrl);
  
    if(currentUrl.includes('experience') || currentUrl.includes('collection') || currentUrl.includes('resource') || currentUrl.includes('hot_tubs')) {
      const footer = document.querySelector('footer');
  
      footer.classList.add("custom-footer");
    }

    //hot tub specification
    $('.info-right__specs__item.additional-specs').on('click', function() {
      $(this).toggleClass('active');
      $(this).find('.specs-item__data').slideToggle('normmal');
    })
	  
	  //Filter
	  $('.filter').on('click', function(e) {
		  e.stopPropagation();
		  $('.filter-dropdown').removeClass('active');
      $('.filter').removeClass('active');
		  $(this).find('.filter-dropdown').toggleClass('active');
      $(this).toggleClass('active');
	  })
	  $(document).click(function (e) {
		const filter = $(".filter");

		//check if the clicked area is dropDown or not
		if ( filter.has(e.target).length === 0 ) {
		  $('.filter-dropdown').removeClass('active');
      $('.filter').removeClass('active');
		}
	  })
  })
});
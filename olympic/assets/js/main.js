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
  
    if(currentUrl.includes('experience') || currentUrl.includes('collection') || currentUrl.includes('resource') || currentUrl.includes('hot_tubs') || currentUrl.includes('brand') || currentUrl.includes('promotion') || currentUrl.includes('specials') || currentUrl.includes('locations')) {
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

    // leadership modal
    $('.leadership-team__item__image').on('click', function() {
      $(this).siblings('.leadership-modal').addClass('active');
      $('[data-css="tve-u-18a091af2e8"]').css('z-index', '9999');
      $('.custom-wave').css('display', 'none');
    })
    $('.leadership-modal .close').on('click', function() {
      $(this).parent().parent().removeClass('active');
      $('[data-css="tve-u-18a091af2e8"]').css('z-index', '1');
      $('.custom-wave').css('display', 'block');
    })

    // collection features modal
    $('.collection-features__item__image').on('click', function() {
      $(this).siblings('.collection-features__modal').addClass('active');
      $('[data-css="tve-u-189abe28316"]').css('z-index', '9999');
      $('.custom-wave').css('display', 'none');
    })
    $('.collection-features__modal .close').on('click', function() {
      $(this).parent().parent().removeClass('active');
      $('[data-css="tve-u-189abe28316"]').css('z-index', '1');
      $('.custom-wave').css('display', 'block');
    })

    //hot tub
    const $list = $('.cpt-list');
    const $pagination = $('.pagination');
    function ajaxCPT() {
      const cat = $list.attr('data-cat');
      const post_type = $list.attr('data-post-type');
      const paged = $list.attr('data-paged');
      const posts_per_page = $list.attr('data-posts-per-page');
      const search = $list.attr('data-search');
      const individual = $list.attr('data-individual');
      const sort = $list.attr('data-sort');
      $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
          action: 'ajax_cpt',
          post_type,
          sort,
          cat,
          individual,
          posts_per_page
        },
        beforeSend() {
          $list.html(
            '<span class="loader"></span>'
          );
          $pagination.hide();
        },
        success(res) {
          const data = JSON.parse(res);
          $list.html(data.output);
          if (data.max_num_pages > 1) {
            $pagination.html(data.pagination);
            $pagination.show();
          }
          // helper.viewportCheckerAnimate('.a-up', 'fadeInUp', true);
        }
      });
    }

    $('.filter-brand').find('.option').on('click', function() {
      $('.filter-dropdown').removeClass('active')
      const text = $(this)[0].innerText;
      const attribute = $(this).attr('value');
      $(this).parent().prev().attr('data-value', attribute)
      $(this).parent().prev().text(text)
      console.log(attribute);
      $list.attr('data-cat', attribute);
      // $list.attr('data-sort', $('.filter-sort').find('.filter-btn').attr('data-value'));
      ajaxCPT();
    })

    $('.hot-tub-product__seemore').on('click', function() {
      $('.filter-dropdown').removeClass('active')
      $list.attr('data-posts-per-page', '-1');
      $list.attr('data-cat', '');
      // $list.attr('data-sort', $('.filter-sort').find('.filter-btn').attr('data-value'));
      ajaxCPT();
    })

  })
});
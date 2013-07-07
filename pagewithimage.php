<?php
include 'template/header.php';
include 'view/logged_in.php';
?>
 <div class ="well pull-right">
                      	
                     <a href="pages.php"><div id="pages_label3">
                                <p>Create New Papercast</p>
                                </div>                     
                     </a>  
                             </div>    

<a class="btn btn-primary" href="pages.php" title="Profile"> Author Papercast</a>  
                     </div> 
                 </div>
             </div>
       <div class="container-fluid">
  <div class="row-fluid">
      <div class="span6">
 <div id="pages_label1">
                           <h3> Upvoted Papercasts </h3>
                     </div>

			 <?php if ($pagesLiked): ?>

			 <?php $total = count($pagesLiked); ?>
			 <?php foreach ($pagesL as $index => $pageL):
			 			$page_name = $pageL['page_name'];
						$page_ID = $pageL['page_ID'];
			 ?>
                    <a href="pages.php?action=showpage&id=<?php echo $page_ID; ?>"><div class="page-list">
                               <p><?php echo $page_name; ?></p>
                               </div>
                    </a>
			<?php endforeach ?>
			<?php else: ?>
					<div class="page_list">
						<p> This user has not upovted papercasts yet</p>
					</div>
			<?php endif; ?>
                         <!-- pages you own -->
                     <div id="pages_label2">
                           <h3>Papercasts You Own</h3>
                     </div>	
                            <!--page list starts here -->
			<?php if ($pagesOwned): ?>
			<?php $total = count($pagesOwned); ?>
			<?php foreach ($pagesO as $index => $pageO):
					$page_name = $pageO['page_name'];
					$page_ID = $pageO['page_ID'];
			?>
                     <a href="pages.php?action=showpage&id=<?php echo $page_ID; ?>"><div class="page-list">
                                <p><?php echo $page_name; ?></p>
                                </div>
                     </a>
			<?php endforeach; ?>
			<?php else: ?>
				<div class="page_list">
					<p>This user doesn't own any Papercasts</p>
				</div>
			<?php endif; ?>


                     



      </div>
      <div class="span3">






            <div id="page_info">
                    <p><?php echo $pagename; ?></p>
                    <div id="page-button">

					<?php if (!$isOwner): ?>
						<?php if (!$isLiked): ?>
    	            	    <a href="pages.php?id=<?php echo $pageID; ?>&action=likepage" class="like-btn" title="Upvote">Upvote</a>
						<?php else: ?>
            		        <a href="pages.php?id=<?php echo $pageID; ?>&action=unlikepage" class="like-btn" title="Downvote">Downvote</a>
						<?php endif; ?>
					<?php endif; ?>
                    </div>

            </div> 
            <div id="page_stream">
                
      
				<?php if ($isOwner): ?>
                   <div id="page-post-box">  
                       <div id="page-post"> 
		                    <div id="types">
		                        
		                            <a href="#" >Text/Link</a>
	             	                
	             	                <a href="pages.php?action=topicpost&id=<?php echo $pageID; ?>">Image</a>
		                        
	                       </div>
                          <div id="box">
		                          <form id="status-form" action="pages.php" method="post" >
		                          <div id="textBox" >
		                          <input type="text" name="status" id="share-text" class="share-text" title="What's on your mind ? "/>
								  <input type="hidden" name="action" value="post" />
								  <input type="hidden" name="pageID" value="<?php echo $pageID; ?>" />
	                             </div>
		                          <input type="submit" id="share-button" class="btn btn-primary" value="post" title="share" />	
		                          <div id="dynaform"></div>
	       	                    </form>
      	                  </div>
                       </div>   
                     </div>
				<?php endif; ?>







      </div>
    </div>
          

       </div>
       </div>                   


                     <div id="page-posts">
						
					<?php
						$total = count($posts);
						foreach ($posts as $index => $post):
							$postID = $post['postID'];
							$postText = $post['postText'];
							$ifImage = $post['ifImage'];
							$timeOn = $post['timeOn'];
					?>
			              <div class="post" id="<?php echo $postID; ?>">
			                     <div class="pdata">
                                     <div class="entry">
           
                                             <a href="#" class="puser"><p><?php echo $pagename; ?></p></a>
                                             <div id="postbox"><?php if($ifImage):?> <?php endif; ?></div>
                                             <div class="bottom-bar">
				                                       <div id="bottom_post">
				                                            <p><?php echo $timeOn; ?></p>
															<?php 
																$current_user = $_SESSION['userid'];
																$hasLikedPost = usersPagePostLike($current_user, $postID);
															?>
															<?php if ($hasLikedPost): ?>
					                                          <p>&nbsp;&nbsp;.&nbsp;&nbsp;<a href="pages.php?pageID=<?php echo $pageID; ?>&postID=<?php echo $postID; ?>&action=unlike" title="Downvote">Downvote</a>&nbsp;.</p>
															<?php else: ?>
					                                          <p>&nbsp;&nbsp;.&nbsp;&nbsp;<a href="pages.php?pageID=<?php echo $pageID; ?>&postID=<?php echo $postID; ?>&action=like" title="Upvote">Upvote</a>&nbsp;.</p>
															<?php endif; ?>
					                                    </div>
															<?php
																$likes = getPagePostLikes($postID);
																if ($likes >= 1):
															?>
					                                    <div id="likes" ><p><?php echo $likes; ?>Upvotes</p></div>
															<?php else: ?>
														<div id="likes"><p>No Upvotes Yet<p></div>
															<?php endif; ?>
															<?php
																/* Fetch comments of current post from the database : */
																$comments = getCommentsOfPagePost($postID);
																$total = count($comments);
																foreach ($comments as $index => $comment):
																	$posterID = $comment['userID'];
																	$commentText = $comment['comment'];
																	$commentTime = $comment['timeOn'];
																	$nameOfCommenter = getUserName($posterID);
																	$picOfCommenter = getCurrentProfilePic($posterID);
																	$fname = $nameOfCommenter['fname'];
																	$lname = $nameOfCommenter['lname'];
															?>
					                                    <div class="comments">
															
															<a href="profile.php?id=<?php echo $posterID; ?>" class="cuser"><p><?php echo " $fname $lname"?></p></a><p><?php echo $commentText; ?></p>
					                                          <div id="bottom_post" >
				                                                   <p><?php echo " $timeOn"; ?></p>
					                                          </div>
					                                     </div> 
														 <?php  endforeach; ?>
                                                   <div id="comment_box">
				                                            <p><img src="<?php echo $mypic; ?>" alt="<?php echo "$currentUserfname $currentUserlname"; ?>" height="30" width="30"/>
															<form action="pages.php" method="post" >
															 	<input type="text" name="comment" class="comment" />
																<input type="hidden" name="action" value="comment" />
																<input type="hidden" name="pageID" value="<?php echo $pageID; ?>" />
																<input type="hidden" name="postID" value="<?php echo $postID; ?>" />
															</form>
															</p>
				                                       </div> 				                            
				                                 </div>    
				                          </div>			                 
			                      </div> 
			              </div>


									<?php endforeach; ?>

<!--



			              <div class="post">
			                      <div class="pdata">
                                      <div class="entry">
                                             <a href="#" class="puser"><p>Page Owner</p></a>
                                             <div id="postbox"><p> ganpati bappa morya !! jai ganesh deva !</p><img src="bappa.jpg" alt="" height="300"width="300"></div>
                                             <div class="bottom-bar">
				                                       <div id="bottom_post">
				                                             <p> Friday, 28 Sept.2012</p><p>5:30 pm</p>
					                                          <p>&nbsp;&nbsp;.&nbsp;&nbsp;<a href="#" title="Like this post">Like</a>&nbsp;.</p>
					                                          <p><a href="#" title="">Comment</a>&nbsp;</p>
					                                    </div>
					                                    <div id="likes" ><p>10 people likes this</p></div>
					                                    <div class="comments"><img src="profile.jpg"alt="name" height="30" width="30"/><a href="" class="cuser"><p>Sandeep Bhoite</p></a><p>Ganpati Bappa Morya !!!</p>
					                                           <div id="bottom_post">
				                                                   <p> Friday, 28 Sept.2012 &nbsp;6:30 pm</p>
					                                                
					                                           </div>
					                                    </div> 
                                                   <div id="comment_box">
				                                             <p><img src="profile.jpg"alt="name" height="30" width="30"/><form action="#" method="post"><input type="text" name="comment" class="comment" value="write your comment here..."/></form></p>
				                                       </div> 				                            
				                                 </div>    
				                           </div>			                 
			                      </div>
			              </div> 
	-->		         </div>
                   
             </div>    <!-- page stream closed-->
             <div>
		<?php include 'view/footer.php' ?>             
       
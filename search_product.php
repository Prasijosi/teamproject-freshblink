<?php include 'start.php';
include 'condition_checker/search_conditonal.php';
?>
<style>
  .checked {
    color: orange;
  }

  .card-text {
    margin-bottom: 10px;
    font-size: 15px !important;
  }

  .card-title {
    margin-bottom: 10px !important;
  }

  .border-secondary {
    border-color: #6c757d !important;
  }

  .border {
    border: 1px solid #dee2e6 !important;
  }
</style>
<div class="container-fluid">
  <section class="container">
    <?php include 'header.php'; ?>
    <div class="row mt-5">
      <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 d-flex align-items-center justify-content-start h6">Advanced Category
      </div>
      <div class="col-9 col-sm-9 col-md-9 col-lg-9 col-xl-9 d-flex align-items-center justify-content-center h6">
        <?php echo $count . " " ?>items found for
        <?php
        if ($search_Txt != "") {
          echo "'" . ucfirst($search_Txt) . "'";
        } elseif ($search_Cat != "") {
          echo "'" . ucfirst($search_Cat) . "'" . " Category";
        } elseif ($product_Category != "") {
          echo "'" . ucfirst($product_Category) . "'" . " Category";
        } elseif ($traders != "") {
          echo "'" . ucfirst($traders) . "'";
        } else {
          echo "' Nothing &#128514;'";
        }
        ?>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
        <form class="clearfix" method="POST" action="search_product.php">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 border border-secondary mt-4 p-4">
            <span class="h6">Product Category
            </span>
            <div class="form-check mt-2">
              <input class="form-check-input" type="radio" value="Bakery" id="defaultCheck1" name="product_Category" />
              <label class="form-check-label" for="defaultCheck1">
                Bakery
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Butcher" id="defaultCheck2" name="product_Category" />
              <label class="form-check-label" for="defaultCheck2">
                Butcher
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Greengrocery" id="defaultCheck3" name="product_Category" />
              <label class="form-check-label" for="defaultCheck3">
                Greengrocery
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Fishmonger" id="defaultCheck4" name="product_Category" />
              <label class="form-check-label" for="defaultCheck4">
                Fishmonger
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Delicatesssen" id="defaultCheck5" name="product_Category" />
              <label class="form-check-label" for="defaultCheck5">
                Delicatesssen
              </label>
            </div>
            <div class="row mt-2">
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-start">
                <button type="submit" name="submit1" class="btn btn-success text-center mt-2">Go</button>
              </div>
            </div>
          </div>
        </form>
        <form method="POST" action="search_product.php">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 border border-secondary mt-4 p-4">
            <span class="h6">
              Traders
            </span>
            <div class="form-check mt-2">
              <input class="form-check-input" type="radio" value="Jack Morris" id="defaultCheck1" name="traders" />
              <label class="form-check-label" for="defaultCheck1">
                Jack Morris
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Tim Hilton" id="defaultCheck2" name="traders" />
              <label class="form-check-label" for="defaultCheck2">
                Tim Hilton
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Jimmy Chu" id="defaultCheck3" name="traders" />
              <label class="form-check-label" for="defaultCheck3">
                Jimmy Chu
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Kamala Harris" id="defaultCheck4" name="traders" />
              <label class="form-check-label" for="defaultCheck4">
                Kamala Harris
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="Tom Hardy" id="defaultCheck5" name="traders" />
              <label class="form-check-label" for="defaultCheck5">
                Tom Hardy
              </label>
            </div>
            <div class="row mt-2">
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-start">
                <button type="submit" name="submit2" class="btn btn-success text-center mt-2">Go</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="col-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
        <div class="row">
          <?php
          for ($counter = 0; $counter < $count; $counter++) {
            echo "
                    <div class='col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 border text-center mt-4'>
                    <a href='product_details.php?product_id=$product_id[$counter]'><img class='img-fluid img-thumbnail mt-4 p-5 text-center' src='$product_image[$counter]' alt='Products'/></a>
                    <a href='product_details.php?product_id=$product_id[$counter]'><h6 class='mt-2'>Product Name</h6> $product_name[$counter]</p></a>
                    <h6>Price</h6> $product_price[$counter]</p>
                    </div>
                    ";
          }

          ?>
        </div>
      </div>
    </div>
  </section>
</div>
<?php include 'footer.php';
include 'end.php';
?>
</body>

</html>
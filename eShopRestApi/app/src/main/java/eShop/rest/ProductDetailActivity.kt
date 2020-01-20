package eShop.rest

import android.app.AlertDialog
import android.content.Intent
import android.os.Bundle
import android.util.Log
import android.widget.TextView
import androidx.appcompat.app.AppCompatActivity
import kotlinx.android.synthetic.main.activity_product_detail.*
import kotlinx.android.synthetic.main.content_product_detail.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.IOException

class ProductDetailActivity : AppCompatActivity(), Callback<Product> {

        private var product: Product? = null

        override fun onCreate(savedInstanceState: Bundle?) {
            super.onCreate(savedInstanceState)
            setContentView(R.layout.activity_product_detail)
            setSupportActionBar(toolbar)

            fabEdit.setOnClickListener {
                val intent = Intent(this, ProductFormActivity::class.java)
                intent.putExtra("eShop.rest.product", product)
                startActivity(intent)
            }

            fabDelete.setOnClickListener {
                val dialog = AlertDialog.Builder(this)
                dialog.setTitle("Confirm deletion")
                dialog.setMessage("Are you sure?")
                dialog.setPositiveButton("Yes") { _, _ -> deleteProduct() }
                dialog.setNegativeButton("Cancel", null)
                dialog.create().show()
            }


            supportActionBar?.setDisplayHomeAsUpEnabled(true)

            val product_id = intent.getIntExtra("eShop.rest.product_id", 0)


            if (product_id > 0) {
                ProductService.instance.get(product_id).enqueue(this)

                val description = intent.getStringExtra("eShop.rest.description")

                val tvProductDetail: TextView = findViewById(R.id.tvProductDetail) as TextView

                tvProductDetail.text = description


            }
        }

        private fun deleteProduct() {
            val product_id = intent.getIntExtra("eShop.rest.product_id", 0)
            ProductService.instance.delete(product_id).enqueue(object : Callback<Void?> {
                override fun onFailure(call: Call<Void?>?, t: Throwable?) {
                    Log.w(TAG, "An error occurred while deleting: ${t?.message}")
                }

                override fun onResponse(call: Call<Void?>?, response: Response<Void?>?) {
                    startActivity(Intent(this@ProductDetailActivity, MainActivity::class.java))
                }
            })
        }

        override fun onResponse(call: Call<Product>, response: Response<Product>) {
            product = response.body()
            Log.i(TAG, "Got result: $product")

            if (response.isSuccessful) {
                tvProductDetail.text = product?.description
                toolbarLayout.title = product?.name
            } else {
                val errorMessage = try {
                    "An error occurred: ${response.errorBody()?.string()}"
                } catch (e: IOException) {
                    "An error occurred: error while decoding the error message."
                }

                Log.e(TAG, errorMessage)
                tvProductDetail.text = errorMessage
            }
        }

        override fun onFailure(call: Call<Product>, t: Throwable) {
            Log.w(TAG, "Error: ${t.message}", t)
        }

        companion object {
            private val TAG = ProductDetailActivity::class.java.canonicalName
        }
}
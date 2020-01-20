package eShop.rest

import android.content.Intent
import android.os.Bundle
import android.util.Log
import androidx.appcompat.app.AppCompatActivity
import kotlinx.android.synthetic.main.activity_main.*
import kotlinx.android.synthetic.main.activity_main.btnSave
import kotlinx.android.synthetic.main.activity_product_form.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.IOException

class ProductFormActivity : AppCompatActivity(), Callback<Void> {

    private var product: Product? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_product_form)

        btnSave.setOnClickListener {
            val name = etName.text.toString().trim()
            val active = etActive.text.toString().trim().toInt()
            val description = etDescription.text.toString().trim()
            val price = etPrice.text.toString().trim().toInt()

            if (product == null) {
                ProductService.instance.insert(name, price,
                        active, description).enqueue(this)
            } else {
                ProductService.instance.update(product!!.product_id, name, price,
                        active, description).enqueue(this)
            }
        }

        val product = intent?.getSerializableExtra("eShop.rest.product") as Product?
        if (product != null) {
            etName.setText(product.name)
            etDescription.setText(product.description)
            etPrice.setText(product.price.toString())
            etActive.setText(product.active.toString())
            this.product = product
        }
    }

    override fun onResponse(call: Call<Void>, response: Response<Void>) {
        val headers = response.headers()

        if (response.isSuccessful) {
            val product_id = if (product == null) {
                Log.i(TAG, "Insertion completed.")
                val parts = headers.get("Location")?.split("/".toRegex())?.dropLastWhile { it.isEmpty() }?.toTypedArray()
                parts?.get(parts.size - 1)?.toInt()
            } else {
                Log.i(TAG, "Editing saved.")
                product!!.product_id
            }

            val intent = Intent(this, ProductDetailActivity::class.java)
            intent.putExtra("eShop.rest.product_id", product_id)
            startActivity(intent)
        } else {
            val errorMessage = try {
                "An error occurred: ${response.errorBody()?.string()}"
            } catch (e: IOException) {
                "An error occurred: error while decoding the error message."
            }

            Log.e(TAG, errorMessage)
        }
    }

    override fun onFailure(call: Call<Void>, t: Throwable) {
        Log.w(TAG, "Error: ${t.message}", t)
    }

    companion object {
        private val TAG = ProductFormActivity::class.java.canonicalName
    }
}
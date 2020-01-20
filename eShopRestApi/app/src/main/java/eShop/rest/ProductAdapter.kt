package eShop.rest

import android.content.Context
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ArrayAdapter
import android.widget.TextView
import java.util.*

class ProductAdapter (context: Context) : ArrayAdapter<Product>(context, 0, ArrayList()){
    override fun getView(position: Int, convertView: View?, parent: ViewGroup): View {
        val view = if (convertView == null)
            LayoutInflater.from(context).inflate(R.layout.productlist_element, parent, false)
        else
            convertView

        val tvName = view.findViewById<TextView>(R.id.tvName)
        val tvPrice = view.findViewById<TextView>(R.id.tvPrice)


        val product = getItem(position)

        tvName.text = product?.name
        if (product != null) {
            tvPrice.text = String.format(Locale.ENGLISH, "%.2f EUR", product.price.toDouble())
        }

        return view
    }
}
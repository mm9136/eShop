package com.example.eshop.ViewHolder;

import android.view.View;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.eshop.Interface.ItemClickListener;
import com.example.eshop.R;

public class ProductViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener {

    public TextView txtproductName, txtProductDescription,getTxtproductPrice;
    //public ImageView imageView;
    public ItemClickListener listener;

    public ProductViewHolder(@NonNull View itemView) {
        super(itemView);

        //imageView = (ImageView) itemView.findViewById(R.id.product_image);
        txtproductName = (TextView) itemView.findViewById(R.id.product_name);
        txtProductDescription = (TextView) itemView.findViewById(R.id.product_description);
        getTxtproductPrice = (TextView) itemView.findViewById(R.id.product_price);
    }
    public void setItemClickListener(ItemClickListener listener){
        this.listener= listener;
    }
    @Override
    public void onClick(View view) {
        listener.onClick(view, getAdapterPosition(),false);
    }
}

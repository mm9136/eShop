package com.example.eshop;

import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;

import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.navigation.NavigationView;
import com.google.android.material.snackbar.Snackbar;

import io.paperdb.Paper;

public class HomeActivity extends AppCompatActivity
    implements NavigationView.OnNavigationItemSelectedListener
{

    //private AppBarConfiguration mAppBarConfiguration;
    //private DatabaseReference ProductsRef;
    private RecyclerView recyclerView;
    RecyclerView.LayoutManager layoutManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Paper.init(this);
        setContentView(R.layout.activity_home);

        //ProductsRef = FirebaseDatabase.getInstance().getReference().child("Products");


        Toolbar toolbar = findViewById(R.id.toolbar);
        toolbar.setTitle("Home");
        setSupportActionBar(toolbar);


        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener( new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Snackbar.make(view, "Replace with your own action", Snackbar.LENGTH_LONG)
                        .setAction("Action", null).show();
            }
        });


        DrawerLayout drawer = findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toogle= new ActionBarDrawerToggle(
                this, drawer,toolbar,R.string.navigation_drawer_open,R.string.navigation_drawer_close);
        drawer.addDrawerListener(toogle);
        toogle.syncState();

         NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener((NavigationView.OnNavigationItemSelectedListener) this);





        recyclerView=findViewById(R.id.recycler_menu);
        recyclerView.setHasFixedSize(true);
        layoutManager=new LinearLayoutManager(this);
        recyclerView.setLayoutManager(layoutManager);

    }

/*
    @Override
    protected void onStart() {
        super.onStart();
        FirebaseRecycleOptions<Products> options =
                new FirebaseRecycleOptons.Builder<Products>()
                .setQuery(ProductsRef,Products.class);
                .build();
         FirebaseRecycleAdapter<Products, ProductViewHolder> adapter=
                 new FirebaseRecycleAdapter<Products, ProductViewHolder>(options){
                     @Override
                     protected void onBindViewHolder(@NonNull ProductViewHolder holder, int position,@NonNull Products model ){
                            holder.txtproductName.setText(model.getName());
                            holder.txtProductDescription.setText(model.getDescription());
                            holder.getTxtproductPrice.setText("Price =" + model.getPrice() + "EUR");
                            //Picasso.get().load(model.getImage()).into(holder.imageView);
                     }
                     @NonNull
                     @Override
                     public ProductViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType){
                            View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.product_items_layout, parent,false);
                            ProductViewHolder holder = new ProductViewHolder((view));
                            return holder;
                     }

                 };
        recyclerView.setAdapter(adapter);
        adapter.startListening();
    }

*/
    @Override
    public void onBackPressed(){
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if(drawer.isDrawerOpen(GravityCompat.START)){
            drawer.closeDrawer(GravityCompat.START);
        }else{
            super.onBackPressed();
        }
    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.home, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item){
        int id= item.getItemId();
        /*if(id == R.id.action_settings){
            return  true;
        }*/
        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    public boolean onNavigationItemSelected(MenuItem item) {
        int id = item.getItemId();
        if(id == R.id.nav_cart){

        }
        else if(id == R.id.nav_orders){


        }
        else if(id == R.id.nav_categories){
            Intent intent= new Intent(HomeActivity.this,ListProductActivity.class);
            startActivity(intent);

        }
        else if(id == R.id.nav_settings){
                Intent intent= new Intent(HomeActivity.this,SettingsActivity.class);
                startActivity(intent);
        }
        else if(id == R.id.nav_logout){
            Paper.book().destroy();
            Intent intent= new Intent(HomeActivity.this,MainActivity.class);
            intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
            startActivity(intent);
            finish();
        }
        DrawerLayout drawer=(DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }

}

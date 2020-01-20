package com.example.eshop;

import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.example.eshop.Modul.Products;

import java.io.PrintWriter;
import java.io.StringWriter;
import java.io.Writer;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;

public class ListProductActivity extends AppCompatActivity {
    private ArrayList<Products> itemArrayList;  //List items Array
    private MyAppAdapter myAppAdapter; //Array Adapter
    private ListView listView; // ListView
    private boolean success = false; // boolean

    //private static final String DB_URL = "jdbc:mysql://DATABASE_IP/DATABASE_NAME";
    //private static final String DB_URL = "jdbc:mysql://192.168.1.6/DatabaseTest"; //"jdbc:mysql://DATABASE_IP/DATABASE_NAME";
    //private static final String DB_URL = "jdbc:mysql://localhost/eshop";

    private static final String DB_URL = "jdbc:mysql://10.0.2.2:3306/eShop";
    private static final String USER = "root";
    private static final String PASS = "ep";
    private  Connection conn = null;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_list_product);

        listView = (ListView) findViewById(R.id.listView); //ListView Declaration
        itemArrayList = new ArrayList<Products>(); // Arraylist Initialization

        // Calling Async Task
        SyncData orderData = new SyncData();
        orderData.execute("");
    }

    // Async Task has three overrided methods,
    private class SyncData extends AsyncTask<String, String, String> {
        String msg = "Internet/DB_Credentials/Windows_FireWall_TurnOn Error, See Android Monitor in the bottom For details!";
        ProgressDialog progress;

        @Override
        protected void onPreExecute() //Starts the progress dailog
        {
            progress = ProgressDialog.show(ListProductActivity.this, "Synchronising",
                    "Products ListView Loading! Please Wait...", true);
        }

        @Override
        protected String doInBackground(String... strings)  // Connect to the database, write query and add items to array list
        {
            try {
                Class.forName("com.mysql.jdbc.Driver");
                Connection conn = DriverManager.getConnection(DB_URL, USER, PASS); //Connection Object
                if (conn == null) {
                    success = false;
                } else {
                    // Change below query according to your own database.
                    String query = "SELECT * FROM product";
                    Statement stmt = conn.createStatement();
                    ResultSet rs = stmt.executeQuery(query);
                    if (rs != null) // if resultset not null, I add items to itemArraylist using class created
                    {
                        while (rs.next()) {
                            try {
                                itemArrayList.add(new Products(rs.getString("product_id"), rs.getString("name"),rs.getString("price"),rs.getString("description"),rs.getString("active")));
                            } catch (Exception ex) {
                                ex.printStackTrace();
                            }
                        }
                        msg = "Found";
                        success = true;
                    } else {
                        msg = "No Data found!";
                        success = false;
                    }
                }
            } catch (Exception e) {
                e.printStackTrace();
                Writer writer = new StringWriter();
                e.printStackTrace(new PrintWriter(writer));
                msg = writer.toString();
                success = false;
            }
            return msg;
        }

        @Override
        protected void onPostExecute(String msg) // disimissing progress dialoge, showing error and setting up my ListView
        {
            progress.dismiss();
            Toast.makeText(ListProductActivity.this, msg + "", Toast.LENGTH_LONG).show();
            if (success == false) {
            } else {
                try {
                    myAppAdapter = new MyAppAdapter(itemArrayList, ListProductActivity.this);
                    listView.setChoiceMode(ListView.CHOICE_MODE_MULTIPLE);
                    listView.setAdapter(myAppAdapter);
                } catch (Exception ex) {

                }

            }
        }
    }

    public class MyAppAdapter extends BaseAdapter         //has a class viewholder which holds
    {
        public class ViewHolder {
            TextView product_name;
            TextView product_price;
            TextView product_description;
            //ImageView imageView;
        }

        public List<Products> parkingList;

        public Context context;
        ArrayList<Products> arraylist;

        private MyAppAdapter(ArrayList<Products> apps, Context context) {
            this.parkingList = apps;
            this.context = context;
            arraylist = new ArrayList<Products>();
            arraylist.addAll(parkingList);
        }

        @Override
        public int getCount() {
            return parkingList.size();
        }

        @Override
        public Object getItem(int position) {
            return position;
        }

        @Override
        public long getItemId(int position) {
            return position;
        }

        @Override
        public View getView(final int position, View convertView, ViewGroup parent) // inflating the layout and initializing widgets
        {

            View rowView = convertView;
            ViewHolder viewHolder = null;
            if (rowView == null) {
                LayoutInflater inflater = getLayoutInflater();
                rowView = inflater.inflate(R.layout.product_items_layout, parent, false);
                viewHolder = new ViewHolder();
                viewHolder.product_name = (TextView) rowView.findViewById(R.id.product_name);
                viewHolder.product_price = (TextView) rowView.findViewById(R.id.product_price);
                viewHolder.product_description = (TextView) rowView.findViewById(R.id.product_description);
                //viewHolder.imageView = (ImageView) rowView.findViewById(R.id.imageView);
                rowView.setTag(viewHolder);
            } else {
                viewHolder = (ViewHolder) convertView.getTag();
            }
            // here setting up names and images
            viewHolder.product_name.setText(parkingList.get(position).getName() + "");
            //Picasso.with(context).load(parkingList.get(position).getImg()).into(viewHolder.imageView);

            return rowView;
        }
    }
}


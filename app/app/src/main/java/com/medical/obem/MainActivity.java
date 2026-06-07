package com.medical.obem;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.github.ybq.android.spinkit.sprite.Sprite;
import com.github.ybq.android.spinkit.style.FadingCircle;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.AuthResult;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;

import cn.pedant.SweetAlert.SweetAlertDialog;
import es.dmoral.toasty.Toasty;

public class MainActivity extends AppCompatActivity {
    private DatabaseReference mDatabase;
    private Button login;
    private TextView fpass;
    private EditText email,password;
    private FirebaseAuth mAuth;
    private ProgressBar loading;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        mDatabase = FirebaseDatabase.getInstance().getReference();
        email = findViewById(R.id.email);
        password = findViewById(R.id.pass);
        login = findViewById(R.id.login);
        loading=findViewById(R.id.progressBar);
        loading.setVisibility(View.INVISIBLE);
        fpass=findViewById(R.id.forget);
        Sprite FadingCircle = new FadingCircle();
        loading.setIndeterminateDrawable(FadingCircle);
        mAuth = FirebaseAuth.getInstance();
        final FirebaseUser user = mAuth.getCurrentUser();
        if (user != null) {

                        startActivity(new Intent(getApplicationContext(), HomeActivity.class));
                        finish();

        }

        fpass.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getApplicationContext(), ForgetPassword.class));
            }
        });

        login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                login.setVisibility(View.INVISIBLE);
                loading.setVisibility(View.VISIBLE);

                String emaill = email.getText().toString().trim();
                String pass = password.getText().toString().trim();

                boolean flag=false;

                if (emaill.isEmpty()) {
                    flag= true;
                    email.setError("Fields can't be empty");
                    login.setVisibility(View.VISIBLE);
                    loading.setVisibility(View.INVISIBLE);

                }
                if (pass.isEmpty()){
                    flag=true;
                    password.setError("Fields can't be empty");
                    login.setVisibility(View.VISIBLE);
                    loading.setVisibility(View.INVISIBLE);

                }
                if(flag == false){
                    // if everything is fine, sign in
                    email.setError(null);
                    password.setError(null);

                        Login(emaill,pass);



                }
            }

        });



    }

    private void Login(String emaill, String pass) {
        mAuth.signInWithEmailAndPassword(emaill, pass).addOnCompleteListener(new OnCompleteListener<AuthResult>() {
            @Override
            public void onComplete(@NonNull Task<AuthResult> task) {
                if(task.isSuccessful()){
                    onAuthSuccess(task.getResult().getUser());
                }
                else {
                    login.setVisibility(View.VISIBLE);
                    loading.setVisibility(View.INVISIBLE);
                    Toasty.error(getApplicationContext(), "Login Fail", Toast.LENGTH_SHORT).show();
                    Log.e("error", String.valueOf(task.getException()));
                }
            }
        });
    }

    private void onAuthSuccess(final FirebaseUser user) {
        if (user != null) {

            mDatabase= FirebaseDatabase.getInstance().getReference("Health Status").child("Patient").child(user.getUid());
            mDatabase.addListenerForSingleValueEvent(new ValueEventListener() {
                @Override
                public void onDataChange(DataSnapshot dataSnapshot) {

                    if (dataSnapshot.exists()) {
                        boolean emailVerified = user.isEmailVerified();
                        if (emailVerified){
                            startActivity(new Intent(getApplicationContext(), HomeActivity.class));
                            finish();
                        }

                           else
                        {
                            login.setVisibility(View.VISIBLE);
                            loading.setVisibility(View.INVISIBLE);
                            Toasty.error(getApplicationContext(), "Please verify your email", Toast.LENGTH_SHORT).show();
                            Log.e("error", String.valueOf(emailVerified));
                        }

                    }
                    else{
                        boolean emailVerified = user.isEmailVerified();
                        if (emailVerified){
                            startActivity(new Intent(getApplicationContext(), RegisterActivity.class));
                            finish();
                        }
                        else
                        {
                            login.setVisibility(View.VISIBLE);
                            loading.setVisibility(View.INVISIBLE);
                            Toasty.error(getApplicationContext(), "Please verify your email", Toast.LENGTH_SHORT).show();
                            Log.e("error", String.valueOf(emailVerified));
                        }

                    }
                }

                @Override
                public void onCancelled(DatabaseError databaseError) {

                }
            });
        }
    }
    public void onBackPressed() {
        //super.onBackPressed();
        SweetAlertDialog progressDialog = new SweetAlertDialog(this, SweetAlertDialog.WARNING_TYPE);
        progressDialog.setCancelable(false);
        progressDialog.setTitleText("Are you sure you want to exit?");
        progressDialog.setCancelText("No");
        progressDialog.setConfirmText("Yes");
        progressDialog.setCanceledOnTouchOutside(true);
        progressDialog.setConfirmClickListener(new SweetAlertDialog.OnSweetClickListener() {
            @Override
            public void onClick(SweetAlertDialog sweetAlertDialog) {
                sweetAlertDialog.dismiss();
                finishAffinity();
               finish();
            }
        });
        progressDialog.show();
    }
}

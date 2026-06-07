package com.medical.obem.model;

public class Overview {

    private int sumOfEatCal;


    public Overview() {
    }

    public Overview( int sumOfEatCal) {

        this.sumOfEatCal = sumOfEatCal;
    }


    public int getSumOfEatCal() {
        return sumOfEatCal;
    }

    public void setSumOfEatCal(int sumOfEatCal) {
        this.sumOfEatCal = sumOfEatCal;
    }
}

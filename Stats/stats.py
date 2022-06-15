#Should print the stats to a file called stats.txt
#Reads in Ethics-Entries.csv and Feedback.csv

import numpy as np
import pandas as pd
import matplotlib as plt


def read():
    ethics = pd.read_csv("Ethics-Entries.csv")
    feedback = pd.read_csv("Feedback.csv")
    return ethics, feedback


if __name__ == "__main__":
    ethics, feedback = read()
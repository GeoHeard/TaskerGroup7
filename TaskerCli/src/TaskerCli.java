/**
 * This is the main class for the program TaskerCli, developed for
 * the CS22120 group project, by group 07.
 * 
 * This class is the centre of the program. It stores all of the 
 * tasks for the user and initialises the main components of the GUI.
 * The ‘main screen’ is supposed to provide a list of buttons, one
 * for each class, that once pressed interacts with the given task 
 * object and loads the task into the GUI. This class provides a 
 * reference to the ‘synchroniser’ so that when necessary, tasks can 
 * be loaded, synchronised or saved.

 * 
 * @author Group 07: kuh1, 
 * @version 0.1
 * @date 24/11/2015
 *
 */
public class TaskerCli {
	
	private Task[] tasks;
	private Synchroniser synchroniser;
	//private LoginScreen loginScreen
	//private MainScreen mainScreen;
	
	/**
	 * Starts the program by initialising the login screen.
	 * @param args
	 */
	public static void main(String [] args){
		TaskerCli tasker = new TaskerCli();
		tasker.initialiseLoginScreen();
	}
	
	/**
	 * Initialises the GUI that allows the user to log in.
	 * 
	 * Currently initialises a command line interface for 
	 * prototype.
	 */
	public void initialiseLoginScreen(){
		
	}
	
	/**
	 * Initialises the GUI after the user has successfully
	 * logged in. 
	 * 
	 * Currently initialises a command line interface for 
	 * prototype.
	 */
	public void initialiseMainScreen(){
		
	}
	
	/**
	 * Called by pressing the ’log in’ button on the GUI. 
	 * Creates a new synchroniser with the input email.
	 * Attempts to load the relevant tasks from local storage
	 * and then synchronise them with the tasks on TaskerSvr.
	 * If successful the main screen GUI is loaded. If no
	 * tasks could be retrieved an error message is output
	 * and the user has to try a different email to continue.
	 * 
	 * @param userEmail
	 * 				The input email address.
	 */
	public void login(String userEmail){
		
	}
	
	/**
	 * Calls the synchroniser to synchronise tasks. Allows a
	 * task object to request changes made to be saved.
	 */
	public void saveChanges(){
		
	}
}

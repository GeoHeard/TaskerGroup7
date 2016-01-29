package uk.ac.aber.cs221.group_7.util.TaskerCli_GUI;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.Font;
import java.awt.GridLayout;
import java.awt.event.ActionEvent;
import java.util.ArrayList;

import javax.swing.AbstractAction;
import javax.swing.BorderFactory;
import javax.swing.Box;
import javax.swing.JButton;
import javax.swing.JMenuBar;
import javax.swing.JOptionPane;
import javax.swing.JPanel;

import uk.ac.aber.cs221.group_7.util.TaskerCli.Status;
import uk.ac.aber.cs221.group_7.util.TaskerCli.Task;
import uk.ac.aber.cs221.group_7.util.TaskerCli.TaskerCli;
	
/**
* This class provides a JPanel that displays the main screen.
* All of the tasks are listed on the left hand side as buttons.
* Once the button is pressed the middle JPanel is swapped for one containing
* the information about the selected task.
* @author kuh1
*/
public class MainScreen extends JPanel{
	private TaskerCli tasker;
	private ArrayList<Task> tasks;
	private JPanel taskPanel;
	private Task currentTask;
	private JMenuBar sideMenu;
		
	/**
	* Create the panel for the main screen
	* @param taskerCli
	* 				The instance of the main class that the GUI will interact with to "login"
	*/
	public MainScreen(TaskerCli taskerCli, ArrayList<Task> theTasks){
		super();
		tasker = taskerCli;
		tasks = theTasks;
			
		setLayout(new BorderLayout());
			
		populatePanel(tasks);
			
		//Make sure it is visible
		setVisible(true); 
	}
	
	/**
	 * Creates a new task menu only containing the tasks marked as
	 * 'ALLOCATED'
	 */
	public void refreshTaskMenu(ArrayList<Task> newTasks){
		tasks = newTasks;
		
		remove(sideMenu);
		
		//Add the side menu
        sideMenu = new JMenuBar();
        //Make it a vertical menu
        sideMenu.setLayout(new GridLayout(0,1));
        populateMenu(sideMenu, tasks); 
        //Make sure it sits at the left hand side of the screen and that the section is bordered
        add(sideMenu, BorderLayout.WEST);
        sideMenu.setBorder(BorderFactory.createMatteBorder(0, 0, 0, 2, Color.black));
	}
	
	/**
	 *  If a task is no longer marked 'ALLOCATED' then the panel is removed
	 */
	public void refereshTaskPanel(){
		if(currentTask.getStatus() != Status.ALLOCATED){
			removeTaskPanel();
		}
	}
	
	/**
	 * Resets the task panel to show the original comments before changes if the user has not yet hit 'save changes'
	 */
	public void resetTaskPanel(){
		remove(taskPanel);	
		this.updateTaskPanel(currentTask.initialiseTaskPanel());	
	}
	
	/**
	 * Removes the current task panel and repaints/revalidates
	 */
	private void removeTaskPanel(){
		remove(taskPanel);
		this.revalidate();
		this.repaint();
	}
		
	/**
	 * Populates the panel with a title and a list/menu of tasks down the left hand side
	 * @param theTasks
	 * 				The tasks that the user has been assigned, will be displayed in a menu
	 */
	private void populatePanel(ArrayList<Task> theTasks){
		JPanel title = createTitlePanel("TaskerCli", "Current Tasks");
		//Make sure it sits at the top of the page and that the section is bordered
        add(title , BorderLayout.NORTH);
        title.setBorder(BorderFactory.createMatteBorder(0, 0, 2, 0, Color.black));
        
        //Add the side menu
        sideMenu = new JMenuBar();
        //Make it a vertical menu
        sideMenu.setLayout(new GridLayout(0,1));
        populateMenu(sideMenu, theTasks); 
        //Make sure it sits at the left hand side of the screen and that the section is bordered
        add(sideMenu, BorderLayout.WEST);
        sideMenu.setBorder(BorderFactory.createMatteBorder(0, 0, 0, 2, Color.black));
	}
	
	/**
	 * Creates a panel with a title and a sub title below it.
	 * @param theTitle
	 * 			The title you want to be added to the panel
	 * @param theSubTitle
	 * 			The sub title to be placed below it
	 * @return
	 * 			A panel with the given title and sub title
	 */
	private JPanel createTitlePanel(String theTitle, String theSubTitle){
		JPanel titlePanel = new JPanel();
		titlePanel.setLayout(new GridLayout(0, 1));
		
		//Add the title
		JSLabel title = new JSLabel(theTitle, "Arial", Font.PLAIN, 30);
		titlePanel.add(title);
		//Add the sub title
		JSLabel subTitle = new JSLabel(theSubTitle, "Arial", Font.PLAIN, 18);
		titlePanel.add(subTitle);
		
		return titlePanel;
	}
	
	/**
	 * Populate the given menu with buttons for each task marked "ALLOCATED", 
	 * @param theMenu
	 * 			The menu to populate
	 * @param theTasks
	 * 			The tasks the user has been assigned
	 */
	private void populateMenu(JMenuBar theMenu, ArrayList<Task> theTasks){
		//Loop through each task
		for(int i = 0; i < theTasks.size(); i++){
			//Create a button for each task marked 'allocated'
			if(theTasks.get(i).getStatus() == Status.ALLOCATED){
				theMenu.add(createTaskBtn(theTasks.get(i)));
			}
		}
		
		//If there are no tasks make sure the user knows and doesnt think there is a bug
		if(theMenu.getMenuCount() < 1){
			JOptionPane.showMessageDialog(this, "You do not have any allocated tasks at the moment");
		}
		
		/*
		 * Add blank spaces to the menu if there are less than 10 buttons
		 * This makes the buttons a nice size
		 */
		for(int i = theTasks.size(); i < 10; i++){
			theMenu.add(add(Box.createRigidArea(new Dimension(0,1))));
		}
	}
	
	/**
	 * Create a button for the given task. When the button is pressed the task is displayed
	 * @param task
	 * 			The task to create a button for
	 * @return
	 * 			A button that when clicked displays the information of the given task
	 */
	private JButton createTaskBtn(final Task task){
		//Create a button for the task and define its behaviour 
		JButton taskBtn = new JButton(new AbstractAction(task.getTitle()) {
    		public void actionPerformed(ActionEvent ae) {
    			updateTaskPanel(task.initialiseTaskPanel());
    			currentTask = task;
    		}
    	});
          
		taskBtn.setPreferredSize(new Dimension(150, 100));
		taskBtn.setMaximumSize(new Dimension(150, 100));
		
    	return taskBtn;
	}
	
	/**
	 * Displays the given JPanel in the centre of the screen, the area allocated for the
	 * 'task panel'
	 * @param taskPanel
	 * 				The JPanel to display in the centre of the screen
	 */
	private void updateTaskPanel(JPanel thePanel){
		if(taskPanel != null)
			remove(taskPanel);
			
		taskPanel = thePanel;
		add(taskPanel, BorderLayout.CENTER);
		this.revalidate();
		this.repaint();
	}
}